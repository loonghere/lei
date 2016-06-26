<?php
/**
 * 分页类
 * 使用方法
 * $page = new Page('总数', '每页条数');
 * echo $page->showpage();
 * @author：王雷 loonghere@qq.com
 */
class Page
{
    public $total;       // 总记录
    public $pagesize;    // 每页显示多少条
    public $limit;       // limit
    public $page;        // 当前页码
    public $pagenum;     // 总页码
    public $url;         // 地址
    public $bothnum;     // 两边保持数字分页的量

    // 构造方法初始化
    public function __construct($_total, $_pagesize)
    {
        $this->total = $_total ? $_total : 1;
        $this->pagesize = $_pagesize;
        $this->pagenum = ceil($this->total / $this->pagesize);
        $this->page = $this->setPage();
        $this->limit = "LIMIT ".($this->page-1)*$this->pagesize.",$this->pagesize";
        $this->url = $this->setUrl();
        $this->bothnum = 3;
    }

    // 拦截器
    public function __get($_key)
    {
        return $this->$_key;
    }

    // 获取当前页码
    public function setPage()
    {
        if (!empty($_GET['page'])) {
            if ($_GET['page'] > 0) {
                if ($_GET['page'] > $this->pagenum) {
                    return $this->pagenum;
                } else {
                    return $_GET['page'];
                }
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }

    // 获取地址
    public function setUrl()
    {
        $_url = $_SERVER["REQUEST_URI"];
        $_par = parse_url($_url);
        if (isset($_par['query'])) {
            parse_str($_par['query'],$_query);
            unset($_query['page']);
            $_url = $_par['path'].'?'.http_build_query($_query);
        }
        return $_url;
    }
    // 数字目录
    public function pageList()
    {
        $_pagelist = '';
        for ($i = $this->bothnum; $i >= 1; $i--) {
            $_page = $this->page-$i;
            if ($_page < 1) continue;
            $_pagelist .= ' <a href="'.$this->url.'&page='.$_page.'">'.$_page.'</a> ';
        }
        $_pagelist .= ' <span class="me">'.$this->page.'</span> ';
        for ($i = 1; $i <= $this->bothnum; $i++) {
            $_page = $this->page+$i;
            if ($_page > $this->pagenum) break;
            $_pagelist .= ' <a href="'.$this->url.'&page='.$_page.'">'.$_page.'</a> ';
        }
        return $_pagelist;
    }

    // 首页
    public function first()
    {
        if ($this->page > $this->bothnum+1) {
            return ' <a href="'.$this->url.'">1</a> ...';
        }
    }

    // 上一页
    public function prev()
    {
        if ($this->page == 1) {
            return '<span class="disabled">上页</span>';
        }
        return ' <a href="'.$this->url.'&page='.($this->page-1).'">上页</a> ';
    }

    // 下一页
    public function next()
    {
        if ($this->page == $this->pagenum) {
            return '<span class="disabled">下页</span>';
        }
        return ' <a href="'.$this->url.'&page='.($this->page+1).'">下页</a> ';
    }

    // 尾页
    public function last()
    {
        if ($this->pagenum - $this->page > $this->bothnum) {
            return ' ... <a href="'.$this->url.'&page='.$this->pagenum.'">'.$this->pagenum.'</a> ';
        }
    }

    // 分页信息
    public function showpage()
    {
        $_page = '';
        $_page .= $this->prev();
        $_page .= $this->first();
        $_page .= $this->pageList();
        $_page .= $this->last();
        $_page .= $this->next();
        return $_page;
    }
}