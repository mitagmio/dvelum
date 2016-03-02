<?php
/*
* DVelum project http://code.google.com/p/dvelum/ , http://dvelum.net
* Copyright (C) 2011-2013  Kirill A Egorov
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
class Designer_Factory
{
	/**
	 * Load project
	 * @param Config_Abstract $designerConfig - designer config
	 * @param string $projectFile - project file path
	 * @return Designer_Project
	 * @throws Exception
	 */
	static public function loadProject(Config_Abstract $designerConfig , $projectFile)
	{
		$storage = Designer_Storage::getInstance($designerConfig->get('storage') , $designerConfig);
		return $storage->load($projectFile);
	}

	/**
	 * Get storage
	 * @param array $designerConfig
	 * @return Designer_Storage_Adapter_Abstract
	 */
	static public function getStorage($designerConfig)
	{
		return Designer_Storage::getInstance($designerConfig->get('storage') , $designerConfig);
	}

	/**
	 * Init layout from designer project
	 * @property string $projectFile - designer project related path
	 * @property Config_Abstract $designerConfig
	 * @property array $replaceTemplates, optional
	 * @todo cache the code
	 */
	static public function runProject($projectFile , Config_Abstract $designerConfig , $replace = array(), $renderTo = false)
	{
		/**
		 * @todo slow operation
		 */
		if(!file_exists($projectFile))
			throw new Exception('Invalid project file' . $projectFile);

		/**
		 * @todo slow operation
		 */
		$cachedKey = self::getProjectCacheKey($projectFile);

		$project = Designer_Factory::loadProject($designerConfig, $projectFile);
		$projectCfg = $project->getConfig();

		Ext_Code::setRunNamespace($projectCfg['runnamespace']);

		$projectData['includes'] = self::getProjectIncludes($cachedKey , $project , true , $replace);

		$names = $project->getRootPanels();
		$actionJs = $project->getActionsFile();

		$initCode = '
		    var applicationClassesNamespace = "'.$projectCfg['namespace'].'";
			var applicationRunNamespace = "'.$projectCfg['runnamespace'].'";
		';

		$initCode.= 'Ext.onReady(function(){';

		if(!empty($names))
		{
			if($renderTo){
				$renderTo = str_replace('-', '_', $renderTo);
				$initCode.= '
				app.content = Ext.create("Ext.container.Container", {
					layout:"fit",
					renderTo:"'.$renderTo.'"
				});
      		   ';
			}

			foreach ($names as $name)
			{
				if($project->getObject($name)->isExtendedComponent())
				{
					if($project->getObject($name)->getConfig()->defineOnly)
						continue;

					$initCode.= Ext_Code::appendRunNamespace($name).' = Ext.create("'.Ext_Code::appendNamespace($name).'",{});';
				}
				$initCode.='
					app.content.add('.Ext_Code::appendRunNamespace($name).');
				';
			}

			if($renderTo)
			{
				$initCode.='
			      	app.content.doComponentLayout();
				';
			}
		}

		$initCode.='
		              app.application.fireEvent("projectLoaded");
	           });';

		$resource = Resource::getInstance();

		if($projectData && isset($projectData['includes']) && !empty($projectData['includes']))
		{
			foreach ($projectData['includes'] as $file)
			{
				if(File::getExt($file) == '.css')
				{
					if(strpos($file , '?') === false){
						$file = $file .'?'. $cachedKey;
					}

					$resource->addCss($file , false);
				}else{

					if(strpos($file , '?') === false){
						$file = $file .'?'. $cachedKey;
					}

					$resource->addJs($file , false, false);
				}
			}
		}
		$resource->addInlineJs($initCode);
	}

	/**
	 * Init layout from designer project
	 * @property string $projectFile - designer project related path
	 * @property Config_Abstract $designerConfig
	 * @property array $replaceTemplates, optional
	 * @property string $moduleId
	 * @todo cache the code
	 */
	static public function compileProject($projectFile , Config_Abstract $designerConfig , $replace, $moduleId)
	{
		$projectData = [
				'applicationClassesNamespace' =>false,
				'applicationRunNamespace' => false,
				'includes'=>[
						'js'=>[],
						'css'=>[]
				]
		];

		if(!file_exists($projectFile))
			throw new Exception('Invalid project file' . $projectFile);

		/**
		 * @todo cache slow operation
		 */
		$cachedKey = self::getProjectCacheKey($projectFile);

		$project = Designer_Factory::loadProject($designerConfig, $projectFile);
		$projectCfg = $project->getConfig();

		Ext_Code::setRunNamespace($projectCfg['runnamespace']);

		$includes = self::getProjectIncludes($cachedKey , $project , true , $replace);
		$projectData['applicationClassesNamespace'] = $projectCfg['namespace'];
		$projectData['applicationRunNamespace'] = $projectCfg['runnamespace'];

		$names = $project->getRootPanels();

		$initCode = '';

		if(!empty($names))
		{
			$items = [];

			$c=0;
			foreach ($names as $name)
			{
				// hide first panel title
				if($c==0)
				{
					$panel = $project->getObject($name);
					if($panel->isValidProperty('title') && !empty($panel->title)){
						$panel->title = '';
					}
					$c++;
				}
				$items[] = Ext_Code::appendRunNamespace($name);
			}

		}

		$initCode.='
			Ext.onReady(function(){
				app.application.fireEvent("projectLoaded", "'.$moduleId.'");
			});
		';

		if(!empty($includes))
		{
			foreach ($includes as $file)
			{
				if(File::getExt($file) == '.css')
				{
					if(strpos($file , '?') === false){
						$file = $file .'?'. $cachedKey;
					}
					$projectData['includes']['css'][]=$file;
				}else{

					if(strpos($file , '?') === false){
						$file = $file .'?'. $cachedKey;
					}
					$projectData['includes']['js'][]=$file;
				}
			}
		}
		$projectData['includes']['js'][] = Resource::getInstance()->cacheJs($initCode , true);
		return $projectData;
	}


	/**
	 * Gel list of JS files to include
	 * (load and render designer project)
	 * @param string $cacheKey
	 * @param Designer_Project $project
	 * @param boolean $selfInclude
	 * @param array $replace
	 * @return array
	 */
	static public function getProjectIncludes($cacheKey , Designer_Project $project , $selfInclude = true , $replace = array())
	{
		$applicationConfig = Registry::get('main' , 'config');
		$designerConfig = Config::factory(Config::File_Array, $applicationConfig->get('configs').'designer.php');

		$projectConfig = $project->getConfig();

		$includes = array();

		// include langs
		if(isset($projectConfig['langs']) && !empty($projectConfig['langs']))
		{
			$language = Lang::getDefaultDictionary();
			$lansPath = $designerConfig->get('langs_path');
			$langsUrl = $designerConfig->get('langs_url');

			foreach ($projectConfig['langs'] as $k=>$file)
			{
				$file =  $language.'/'.$file.'.js';
				if(file_exists($lansPath.$file)){
					$includes[] = $langsUrl . $file . '?' . filemtime($lansPath.$file);
				}
			}
		}

		if(isset($projectConfig['files']) && !empty($projectConfig['files']))
		{
			foreach ($projectConfig['files'] as $file)
			{
				$ext = File::getExt($file);

				if($ext === '.js' || $ext === '.css')
				{
					$includes[] = $designerConfig->get('js_url') . $file;

				}else
				{
					$projectFile = $designerConfig->get('configs') . $file;
					$subProject = Designer_Factory::loadProject($designerConfig,  $projectFile);
					$projectKey = self::getProjectCacheKey($projectFile);
					$files = self::getProjectIncludes($projectKey , $subProject , true , $replace);
					unset($subProject);
					if(!empty($files))
						$includes = array_merge($includes , $files);
				}
			}
		}

		Ext_Code::setRunNamespace($projectConfig['runnamespace']);
		Ext_Code::setNamespace($projectConfig['namespace']);

		if($selfInclude)
		{
			$layoutCacheFile = Utils::createCachePath($applicationConfig->get('jsCacheSysPath'), $cacheKey.'.js');

			/**
			 * @todo remove slow operation
			 */
			if(!file_exists($layoutCacheFile))
				file_put_contents($layoutCacheFile, Code_Js_Minify::minify($project->getCode($replace)));

			$includes[] = str_replace('./' , '/' , $layoutCacheFile);
		}
		/*
		 * Project actions
		 */
		$actionFile = $project->getActionsFile();
		/**
		 * @todo slow operation
		 */
		$mTime = 0;
		if(file_exists('.'.$actionFile))
			$mTime = filemtime('.'.$actionFile);

		$includes[] = $actionFile . '?' . $mTime;
		return $includes;
	}
	/**
	 * Calculate cache key for Designer Project file
	 * @param string $projectFile
	 * @return string
	 */
	static public function getProjectCacheKey($projectFile)
	{
		/**
		 * @todo remove slow operation
		 */
		$dManager = new Dictionary_Manager();
		return md5(@filemtime($projectFile) . $projectFile . $dManager->getDataHash());
	}
	/**
	 * Replace code templates
	 * @param array $replaces
	 * @param string $code
	 * @return string
	 */
	static public function replaceCodeTemplates(array $replaces , $code)
	{
		if(!empty($replaces))
		{
			$k = array();
			$v = array();
			foreach ($replaces as $item)
			{
				$k[] = $item['tpl'];
				$v[] = $item['value'];
			}
			return str_replace($k , $v , $code);
		}
		return $code;
	}
}