<?php

/**
 * 纯文本笔记
 * 
 * 新的想法是把每篇笔记单独当作一个md文件来管理，而不是直接写在代码里面
 * 
 * @author Jake
 * @email  singviy@gmail.com
 * 
 */

namespace ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotesController
 * @Route("/notes")
 * @package ServiceBundle\Controller
 */
class NotesController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('ServiceBundle:Notes:index.html.twig',array(
            'list' => array(
                [
                  'title' => '使用composer的终极方法',
                    'url' => $this->generateUrl('service_notes_theultimatewaytousercomposer')
                ],
                [
                    'title' => '使用phpstorm+chrome+xDebug调试php代码',
                    'url' => $this->generateUrl('service_notes_debugphp')
                ],
                [
                    'title' => 'php的一些常识',
                    'url' => $this->generateUrl('service_notes_somecommonsenseaboutphp')
                ],
            )));
    }

    /**
     * @Route("/the-ultimate-way-to-use-composer")
     */
    public function theUltimateWayToUserComposerAction()
    {
        return $this->render('@Service/Notes/note_template.html.twig',array(
            'title' => '使用composer的终极方法',
            'note' => <<<EOT
                 <p>首先你得安装phpstrom,composer,xx-net</p>
                 <p>phpstorm中ctrl+shift+s打开设置，搜索proxy,选manual proxy,选http,host name 填入 127.0.0.1 ，port填入 8087</p>
                 <p>开启xx-net</p>
                 <p>然后在phpstorm中，你项目的根目录右键，菜单最下面有composer,点击init composer或者update dpendency均可，点击下面的setting,默认的command line parameters是：-n --no-progress，改成-n --no-progress --ignore-platform-reqs,就是在后面多加一个参数，现在你就可以愉快的玩耍啦！</p>
                 <p>我这只要两语写的很草率，如果你有任何疑问，邮件admin#yeskn.com，我无论我是否能回答上，几乎会秒回你的</p>
EOT
        ));
    }

    /**
     * @Route("/debug-php")
     * @return Response
     */
    public function debugPhpAction()
    {
        $data = array(
            'title' => '使用phpstorm+chrome+xDebug调试php代码',
            'note'  => <<<EOT
                <p>还在使用die,var_dump,exit调试你的php代码吗？现在教你使用更高级也更方便的方法</p>
                <p>此方法只针对windows,linux也大同小异</p>
                <p>首先你需要安装phpstorm,chrome,xDebug扩展，建议都在官方网站上面下，并且下载最新版，
                    将php_xdebug的dll文件重命名 php_xdebug.dll，放入php的ext目录，然后php.ini中添加zend_extension=php_xdebug.dll
                    </p>
                <p>xdebug配置参考：</p>
                <pre>
                    [xDebug]
                    zend_extension = "D:\Server\php\ext\php_xdebug.dll"
                    xdebug.profiler_append = 0
                    xdebug.profiler_enable = 1
                    xdebug.profiler_enable_trigger = 0
                    xdebug.profiler_output_dir = "D:\Server\\tmp"
                    xdebug.profiler_output_name = "cachegrind.out.%t-%s"
                    xdebug.remote_enable = on
                    xdebug.remote_handler = "dbgp"
                    xdebug.remote_host = "127.0.0.1"
                    xdebug.remote_port="9000"
                    xdebug.trace_output_dir = "D:\\xampp\\tmp"
                    xdebug.idekey= PHPSTORM
                </pre>
                <p>打开phpstorm，ctrl+shift+s打开设置：Language & Framework > PHP > Server 此处填上你当前项目的url,debuger选xdebug</p>
                <p>Language & Framework > PHP > Debug > DBGP Proxy 中ide key 填PHPSTORM，host填localhost,port 80</p>
                <p>哦，对了，还需要chrome安装Xdebug helper扩展，在这个扩展的选项中 ide key 选PHPSTORM ,值也填入PHPSTORM</p>
                <p>点击phpstorm右上角的一个电话的图标，就可以开启监听了，随便在代码里面打入几个断点，然后刷新页面，会自动弹出phpstorm，并且可以看到断点出变量的值</p>
                <p>我这只要两语写的很草率，如果你有任何疑问，邮件admin#yeskn.com，我无论我是否能回答上，几乎会秒回你的</p>


EOT

        );
       return $this->render('@Service/Notes/note_template.html.twig',$data);
    }

    /**
     * some common sense about php
     * @author Jake
     * @Route("/some-common-sense-about-php")
     */
    public function someCommonSenseAboutPhpAction()
    {
        $data = array(
          'title'  => 'php的一些常识',
            'note' => <<<EOT
                <p>快速通用网关接口（Fast Common Gateway Interface／FastCGI）是一种让交互程序与Web服务器通信的协议。FastCGI是早期通用网关接口（CGI）的增强版本。</p>
                <p>apache通过mod_fcgid模块实现。这个模块曾属于第三方，但是在2009年被授予ASF，成为Apache的一个子项目。</p>
                <br/>
                <p>FastCGI像是一个常驻(long-live)型的CGI,FastCGI具有语言无关性.</p>
EOT

        );

        return $this->render('@Service/Notes/note_template.html.twig',$data);
    }


}
