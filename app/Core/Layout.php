<?php

namespace App\Core;

/**
 * Class Layout
 * @package App\Core
 *
 * @property string $_view
 * @property array $_data
 * @property string $content
 * @property string $title
 * @property string $layout
 * @property array $_style
 * @property array $_scripts
 */
class Layout
{
    protected $_view = '';
    protected $_data = [];

    public $content = '';
    public $title = '';
    public $layout = 'main-layout';

    protected $_style = [];
    protected $_scripts = [
        'header' => [],
        'footer' => [],
    ];

    /**
     * @param $view
     */
    public function setView($view)
    {
        $this->_view = $view;
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        $this->_data = $data;
    }

    /**
     * @param $fileName
     */
    public function addStyle($fileName)
    {
        $this->_style[] = $fileName;
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $layoutName
     */
    public function setLayout($layoutName = '')
    {
        $this->layout = $layoutName;
    }

    /**
     * @param string $path
     * @param array $data
     * @return false|string
     */
    public function getFileContent($path = '', $data = []){

        if (!file_exists($path)) {
            throw new \Error('View not found');
        }

        ob_start();
        extract($data);
        include_once "$path";
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * getContent
     */
    public function getContent()
    {
        $viewPath = sprintf('%s/%s.php', VIEWS_PATH, str_replace('.', '/', $this->_view));
        $this->content = $this->getFileContent($viewPath, $this->_data);
    }

    /**
     * @return false|string
     */
    public function getLayout()
    {
        $this->getContent();
        $layout = sprintf('%s/layouts/%s.php', VIEWS_PATH, strtolower($this->layout));
        return $this->getFileContent($layout);
    }

    /**
     * @param $fileName
     */
    public function addScriptHeader($fileName)
    {
        $this->_scripts['header'][] = $fileName;
    }

    /**
     * @param $fileName
     */
    public function addScriptFooter($fileName)
    {
        $this->_scripts['footer'][] = $fileName;
    }

    /**
     * @return mixed
     */
    public function getScriptHeader()
    {
        return $this->_scripts['header'];
    }

    /**
     * @return mixed
     */
    public function getScriptFooter()
    {
        return $this->_scripts['footer'];
    }

    /**
     * @return array
     */
    public function getStyle()
    {
        return $this->_style;
    }

    /**
     * @return string
     */
    public function generalStyle()
    {
        $link = '';
        if ($items = $this->getStyle()) {
            foreach ($items as $item):
                $link .= '<link rel="stylesheet" href="' . $item . '"/>' . PHP_EOL;
            endforeach;
        }
        return $link;
    }

    /**
     * @param array $paths
     * @return string
     */
    protected function generateScript(array $paths = [])
    {
        $scripts = '';
        if ($paths) {
            foreach ($paths as $path):
                $scripts .= '<script src="' . $path . '"></script>' . PHP_EOL;
            endforeach;
        }
        return $scripts;
    }

    /**
     * @return string
     */
    public function generateScriptHeader()
    {
        return $this->generateScript($this->getScriptHeader());
    }

    /**
     * @return string
     */
    public function generateScriptFooter()
    {
        return $this->generateScript($this->getScriptFooter());
    }

    /**
     * @param $path
     * @param array $dataExtra
     */
    public function inc($path, $dataExtra = [])
    {
        $fullPath = sprintf('%s/%s.php', VIEWS_PATH, $path);

        if (file_exists($fullPath)) {
            echo $this->getFileContent($fullPath, array_merge($this->_data, $dataExtra));
        }
    }
}