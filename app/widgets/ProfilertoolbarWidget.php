<?php
/**
 * Created by JetBrains PhpStorm.
 * User: red_fox
 * Date: 05.10.12
 * Time: 17:08
 * To change this template use File | Settings | File Templates.
 */
class ProfilertoolbarWidget extends WidgetBase{

	public static function render($view){
		
		if( PH_DEBUG != TRUE ){
			return;
		}
		
        // Получаем все необходимые данные
        $files = ProfilertoolbarWidget::get_included_files();
        $sql = ProfilertoolbarWidget::get_sql($view);
        $custom = ProfilertoolbarWidget::get_custom();

        $mem_usage = ( memory_get_usage() - PH_DEBUG_MEM_USAGE );
        $time_execution = round(( microtime(true) - PH_DEBUG_TIME_EXECUTION), 5);

        echo '
        <span style="display:none"><![CDATA[<noindex>]]></span>
        <!-- ============================= PROFILER TOOLBAR ============================= -->
        <script type="text/javascript" src="/js/profilertoolbar.js"></script>
        <link rel="stylesheet" href="/css/profilertoolbar.css">
        <div id="ptb">
            <ul id="ptb_toolbar" class="ptb_bg">
                <li class="time" title="application execution time"><span class="icon"></span>'.$time_execution.'</li>
                <li class="ram" title="memory peak usage"><span class="icon"></span>'.$mem_usage.' bytes</li>
                <li class="custom"><span class="icon"></span> logs <span class="total">('.$custom[1].')</span></li>
                <li class="sql"><span class="icon"></span> sql <span class="total">('.$sql[1].')</span></li>
                <li class="files"><span class="icon"></span> files <span class="total">('.$files[1].')</span></li>
                <li class="hide" title="Hide Profiler Toolbar"><span class="icon"></span></li>
                <li class="show" title="Show Profiler Toolbar"><span class="icon"></span></li>
            </ul>
            <div id="ptb_data" class="ptb_bg" style="display: none;">
                '.$files[0].'
                '.$sql[0].'
                '.$custom[0].'
            </div>
        </div>
        <!-- ============================= /PROFILER TOOLBAR ============================= -->
        <span style="display:none"><![CDATA[</noindex>]]></span>
        ';
	}

    // Подключенные файлы
    public static function get_included_files(){

        $files = get_included_files();

        $c = 1;
        $files_view = '';

        foreach ($files as $value) {
            $files_view .= '<tr><td>' . $c . '</td><td> ' . $value . '</td></tr>';
            $c++;
        }

        unset($c);

        // Всего подключенных файлов
        $total_inludes_files = count($files);

        $reslult = '
        <div id="ptb_data_cont_files" class="ptb_data_cont" style="display: none;">
            <ul class="ptb_tabs">
                <li id="ptb_tab_files">files <span>(' . $total_inludes_files . ')</span></li>
            </ul>
            <div id="ptb_tab_cont_files" class="ptb_tab_cont">
                <table class="ptb_tab_cont_table">
                    <tbody>
                        <tr>
                            <th style="width:20px;">№</th>
                            <th>file</th>
                        </tr>

                        ' . $files_view . '

                        <tr class="total">
                            <th></th>
                            <th>total ' . $total_inludes_files . ' files</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';

        return array($reslult, $total_inludes_files);
    }

    // Инфо по sql запросам
    public static function get_sql($di){

	    if( !isset($di->profiler) ){
		    return array('',0);
	    }
	    
        $profiles = $di->profiler->getProfiles();

        // Всего запросов
        $total_sql_queries = count($profiles);

        $c = 1;
        $total_elapsed_time = 0;
        $sql_view = '';

        foreach ($profiles as $profile) {

            $sql_view .= '
            <tr valign="top">
                <td>' . $c . '</td>
                <td> ' . $profile->getSQLStatement() . ' </td>
                <td class="tRight"> ' . $profile->getTotalElapsedSeconds() . ' s</td>
            </tr>';

            $total_elapsed_time += $profile->getTotalElapsedSeconds();

            $c++;
        }

        unset($c);

        $result = '
        <div id="ptb_data_cont_sql" class="ptb_data_cont">
            <ul class="ptb_tabs">
                <li id="ptb_tab_sqldefault">default <span>(' . $total_sql_queries . ')</span></li>
            </ul>
            <div id="ptb_tab_cont_sqldefault" class="ptb_tab_cont">
                <table class="ptb_tab_cont_table">
                    <tbody>
                        <tr>
                            <th style="width:20px;">№</th>
                            <th>query</th>
                            <th style="width:100px;">time</th>
                        </tr>

                        ' . $sql_view . '

                        <tr class="total">
                            <td></td>
                            <td>total ' . $total_sql_queries . ' queries</td>
                            <td class="tRight">' . $total_elapsed_time . ' s</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';

        return array($result, $total_sql_queries);
    }

    // Кастом
    public static function get_custom(){

        $total = 30;

        $reslult = '
        <div id="ptb_data_cont_custom" class="ptb_data_cont" style="display: none;">
            <ul class="ptb_tabs">
                <li id="ptb_tab_custom_default">messages <span>()</span></li>
            </ul>
            <div id="ptb_tab_cont_custom_default" class="ptb_tab_cont">
                <table class="ptb_tab_cont_table">
                    <tbody>
                        <tr>
                            <th style="width:20px;">№</th>
                            <th>message</th>
                        </tr>

                        <tr class="total">
                            <th></th>
                            <th>total ' . $total . ' messages</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';

        return array($reslult, $total);
    }

}
