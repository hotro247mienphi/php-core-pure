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
        if ($items = $this->getStyle()) {
            $link = '';
            foreach ($items as $item):
                $link .= '<link rel="stylesheet" href="' . $item . '"/>' . PHP_EOL;
            endforeach;
            return $link;
        }
        return '';
    }

    /**
     * @return string
     */
    public function generateScriptHeader()
    {
        if ($items = $this->getScriptHeader()) {
            $scripts = '';
            foreach ($items as $item):
                $scripts .= '<script src="' . $item . '"></script>' . PHP_EOL;
            endforeach;
            return $scripts;
        }

        return '';
    }

    /**
     * @return string
     */
    public function generateScriptFooter()
    {
        if ($items = $this->getScriptFooter()) {
            $scripts = '';
            foreach ($items as $item):
                $scripts .= '<script src="' . $item . '"></script>' . PHP_EOL;
            endforeach;
            return $scripts;
        }
        return '';
    }

    /**
     * @param $path
     */
    public function inc($path)
    {
        if (file_exists($fullPath = VIEWS_PATH . '/' . $path . '.php')) {
            include "$fullPath";
        }
    }
}