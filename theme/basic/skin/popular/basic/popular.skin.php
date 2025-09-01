<?php
if (!defined("_GNUBOARD_")) exit;

add_stylesheet('<link rel="stylesheet" href="'.$popular_skin_url.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/owlcarousel/owl.carousel.min.js"></script>', 10);
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/owlcarousel/owl.carousel.min.css">', 10);
?>

<section id="popular">
    <!-- 인기검색어 -->
    <div class="best_keyword">
        <h2 class="keyword_tit">Best Keyword</h2>
        <ul class="best_keyword_ul">
            <li><a href=""><span class="keyword_num">01</span>텀블러</a></li>
            <li><a href=""><span class="keyword_num">02</span>양산</a></li>
            <li><a href=""><span class="keyword_num">03</span>텀꾸</a></li>
            <li><a href=""><span class="keyword_num">04</span>런치박스</a></li>
            <li><a href=""><span class="keyword_num">05</span>파우치</a></li>
        </ul>
    </div>

    <!-- 최근검색어 -->
    <div class="popular_inner">
        <h2>Recent Searches</h2>
        <ul id="recent_search_list_popular">
            <li>최근검색어가 없습니다.</li>
        </ul>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    try {
        let stxFromServer = <?php echo json_encode(trim(isset($stx) ? $stx : "")); ?>;
        let keywords = JSON.parse(localStorage.getItem("recentSearch")) || [];

        // 서버 검색어가 있을 경우만 추가
        if(stxFromServer){
            keywords = keywords.filter(word => word !== stxFromServer);
            keywords.unshift(stxFromServer);
            keywords = keywords.slice(0,5);
            localStorage.setItem("recentSearch", JSON.stringify(keywords));
        }

        const list = document.getElementById("recent_search_list_popular");

        function renderRecent(){
            if(keywords.length === 0){
                list.innerHTML = "<li>최근검색어가 없습니다.</li>";
            } else {
                list.innerHTML = keywords.map(k => 
                    `<li>
                        <a href="<?php echo G5_BBS_URL ?>/search.php?sfl=wr_subject&sop=and&stx=${encodeURIComponent(k)}">${k}</a>
                        <button class="recent_del" data-key="${k}">
                            <svg width="16" height="16" viewBox="0 0 40 40">
                                <path d="M10.6664 31.0893L8.91016 29.3331L18.2435 19.9997L8.91016 10.6664L10.6664 8.91016L19.9997 18.2435L29.3331 8.91016L31.0893 10.6664L21.756 19.9997L31.0893 29.3331L29.3331 31.0893L19.9997 21.756L10.6664 31.0893Z" fill="#000" stroke="#000" stroke-width="2"/>
                            </svg>
                        </button>
                    </li>`
                ).join("");
            }
        }

        renderRecent();

        // 삭제 이벤트 (DOM에서 즉시 제거, 페이지 리로드 없이)
        list.addEventListener("click", function(e){
            const btn = e.target.closest(".recent_del");
            if(!btn) return;

            const li = btn.closest("li");
            if(li) li.remove(); // 화면에서 즉시 제거

            const key = btn.dataset.key;
            keywords = keywords.filter(k => k !== key);
            localStorage.setItem("recentSearch", JSON.stringify(keywords));

            // renderRecent() 호출 안 함 → 검색창 위치 변화 없음
        });

    } catch(e){
        console.error("[Popular] render error:", e);
    }
});
</script>



<?php if (isset($list) && $list && is_array($list)) { ?>
<script>
jQuery(function($){
    var popular_el = ".popular_inner ul",
        p_width = $(popular_el).width(),
        c_width = 0;

    $(popular_el).children().each(function() {
        c_width += $(this).outerWidth(true);
    });

    if(c_width > p_width){
        var $popular_btns = $(".popular_inner .popular_btns");
        $popular_btns.show();

        var p_carousel = $(popular_el).addClass("owl-carousel").owlCarousel({
            items:5,
            loop:true,
            nav:false,
            dots:false,
            autoWidth:true,
            mouseDrag:false,
        });

        $popular_btns.on("click", ".pp-next", function(e) {
            e.preventDefault();
            p_carousel.trigger('next.owl.carousel');
        }).on("click", ".pp-prev", function(e) {
            e.preventDefault();
            p_carousel.trigger('prev.owl.carousel');
        });
    }
});
</script>
<?php } ?>
