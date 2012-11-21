


App.JST['issues/issue'] = {
    className : 'task-item',
    tagName : 'div',
    layout : _.template(''
        + '<div class="task-item_header">'
            + '<a href="" class="pull-left">#<%= id %></a>'
            + '<a href="" class="pull-right">ZFM</a>'
        + '</div>'
        + '<div class="task-item_content">'
            + '<h5 class=""><%= title %></h5>'
            + '<p><%= description %></p>'
        + '</div>'
        + '<div class="task-item_info clearfix">'
            + '<a href="" class="pull-left"><img src="img/temp-img.png" alt=""></a>'
            + '<span class="task-item_time"><%= estimate %></span>'
        + '</div>'
    )
}


App.JST['issues/feature'] = {
    className : 'task-column-header',
    tagName : 'div',
    layout : _.template(''
        + '<span class="task-column-header-number"><a href="">#<%= id %></a></span>'
        + '<span class="task-column-header-title"><%= title %></span>'
    )
};


App.JST['issues/group'] = {
    className : '',
    tagName : 'div',
    layout : ''
        + '<div class="row-fluid feature-line">'
            + '<div class="span3">'
                + '<div class="column-line"></div>'
            + '</div>'
            + '<div class="span3">'
                + '<div class="column-line"></div>'
            + '</div>'
            + '<div class="span3">'
                + '<div class="column-line"></div>'
            + '</div>'
            + '<div class="span3">'
                + '<div class="column-line"></div>'
            + '</div>'
        + '</div>'
};


App.JST['issues/board'] = {
    className : '',
    tagName : 'div',
    layout : ''
        +'<div class="board-wrap">'
            +'<div class="row-fluid">'
                +'<div class="span3">'
                    +'<div class="column-header">'
                        +'<h3><span>Submitted</span></h3>'
                    +'</div>'
                +'</div>'
                +'<div class="span3">'
                    +'<div class="column-header">'
                        +'<h3><span>In Progress</span></h3>'
                    +'</div>'
                +'</div>'
                +'<div class="span3">'
                    +'<div class="column-header">'
                        +'<h3><span>Test</span></h3>'
                    +'</div>'
                +'</div>'
                +'<div class="span3">'
                    +'<div class="column-header">'
                        +'<h3><span>Done</span></h3>'
                    +'</div>'
                +'</div>'
            +'</div>'
            +'<div class="issues-groups"></div>'
        +'</div>'
};