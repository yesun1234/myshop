<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}
include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>

<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>
    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>
    <div id="tnb">
    	<div class="inner">
            <?php if(G5_COMMUNITY_USE) { ?>
    		<ul id="hd_define">
                <li>
                    <button class="ham gnb_menu_btn">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M28 7H4" stroke="#1A1A1A" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M28 16H4" stroke="#1A1A1A" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M28 25H4" stroke="#1A1A1A" stroke-width="3.6" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </li>
    			<li class="active"><a href="<?php echo G5_URL ?>/">Tumggu</a></li>
                <?php
                    $menu_datas = get_menu_db(0, true);
                    $gnb_zindex = 999; // gnb_1dli z-index 값 설정용
                    $i = 0;
                    foreach( $menu_datas as $row ){
                        if( empty($row) ) continue;
                        if($row['me_name'] == 'Promotion' || $row['me_name'] == 'Brand') continue;

                        $add_class = '';
                        $add_class = (isset($row['sub']) && $row['sub']) ? 'gnb_al_li_plus' : '';
                    ?>
                    <li class="gnb_1dli <?php echo $add_class; ?>" style="z-index:<?php echo $gnb_zindex--; ?>">
                        <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da">
                            <?php echo $row['me_name'] ?>
                        </a>
                    </li>

                    <?php
                    $i++;
                    }   //end foreach $row

                    if ($i == 0) {  ?>
                        <li class="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
                    <?php } ?>
    		</ul>
            <div id="logo">
            <a href="<?php echo G5_URL ?>">Tumbler</a>
        </div>
            <?php } ?>
			<ul id="hd_qnb">
            <?php
                $menu_datas = get_menu_db(0, true);
                $gnb_zindex = 999; // z-index용
                $i = 0;

                foreach( $menu_datas as $row ){
                    if( empty($row) ) continue;
                    
                    // 제외할 메뉴
                    if($row['me_name'] == 'New' || $row['me_name'] == 'Tumbler' || $row['me_name'] == 'Life' || $row['me_name'] == 'Bag') continue;

                    $add_class = (isset($row['sub']) && $row['sub']) ? 'gnb_al_li_plus' : '';
                        ?>
                <li class="gnb_1dli <?php echo $add_class; ?>" style="z-index:<?php echo $gnb_zindex--; ?>">
                    <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da">
                        <?php echo $row['me_name'] ?>
                    </a>

                    <?php if(isset($row['sub']) && $row['sub']) { ?>
                    <ul class="gnb_2dul">
                        <?php foreach((array)$row['sub'] as $sub){ 
                            if(empty($sub)) continue;
                        ?>
                        <li class="gnb_2dli">
                            <a href="<?php echo $sub['me_link']; ?>" target="_<?php echo $sub['me_target']; ?>" class="gnb_2da">
                                <?php echo $sub['me_name']; ?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>
                <?php
                    $i++;
                }

                if ($i == 0) {  ?>
                    <li class="gnb_empty">메뉴 준비 중입니다.
                        <?php if ($is_admin) { ?> 
                            <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.
                        <?php } ?>
                    </li>
                <?php } ?>

                </li>
                <li id='searchIcon' class="gnb_2dli">
                    <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="search 1">
                            <path id="vector" d="M15.2233 25.3333C21.1143 25.3333 25.89 20.5577 25.89 14.6667C25.89 8.77563 21.1143 4 15.2233 4C9.33227 4 4.55664 8.77563 4.55664 14.6667C4.55664 20.5577 9.33227 25.3333 15.2233 25.3333Z" stroke="#1A1A1A" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path id="vector" d="M28.5566 28.0002L22.7566 22.2002" stroke="#1A1A1A" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                    
                </li>
	            
	            <li class="gnb_1dli"><a href="<?php echo G5_SHOP_URL ?>/">
                        <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path id="Vector" d="M27.2232 28V25.3333C27.2232 23.9188 26.6613 22.5623 25.6611 21.5621C24.6609 20.5619 23.3044 20 21.8899 20H11.2232C9.80874 20 8.45218 20.5619 7.45199 21.5621C6.4518 22.5623 5.88989 23.9188 5.88989 25.3333V28" stroke="#1A1A1A" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"></path> 
                            <path id="Vector_2" d="M16.5567 14.6667C19.5022 14.6667 21.8901 12.2789 21.8901 9.33333C21.8901 6.38781 19.5022 4 16.5567 4C13.6112 4 11.2234 6.38781 11.2234 9.33333C11.2234 12.2789 13.6112 14.6667 16.5567 14.6667Z" stroke="#1A1A1A" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </a>
                    <ul class="hd_login gnb_2dul"  >
                        <?php if ($is_member) {  ?>
                        <li class="gnb_2dli"><a class="gnb_2da" href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">정보수정</a></li>
                        <li class="gnb_2dli"><a class="gnb_2da" href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a></li>
                        <?php if ($is_admin) {  ?>
                        <li class="tnb_admin gnb_2dli"><a class="gnb_2da" href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>">관리자</a></li>
                        <?php }  ?>
                        <?php } else {  ?>
                            <li class="gnb_2dli"><a class="gnb_2da" href="<?php echo G5_BBS_URL ?>/register.php">Join</a></li>
                            <li class="gnb_2dli"><a class="gnb_2da" href="<?php echo G5_BBS_URL ?>/login.php">Login</a></li>
                        <?php }  ?>
                        <li class="gnb_2dli">
                            <a class="gnb_2da" href="<?php echo G5_SHOP_URL ?>/">My Page</a>
                        </li>
                        <li class="gnb_2dli">
                            <a class="gnb_2da" href="<?php echo G5_SHOP_URL ?>/">Order</a>
                        </li>
                        <li class="gnb_2dli">
                            <a class="gnb_2da" href="<?php echo G5_SHOP_URL ?>/">Membership</a>
                        </li>
                    </ul>
                </li>
                <li class="gnb_1dli"><a href="<?php echo G5_BBS_URL ?>/new.php">
                    <svg width="33" height="32" viewBox="0 0 33 32" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.5567 29.3332C13.2931 29.3332 13.8901 28.7362 13.8901 27.9998C13.8901 27.2635 13.2931 26.6665 12.5567 26.6665C11.8203 26.6665 11.2234 27.2635 11.2234 27.9998C11.2234 28.7362 11.8203 29.3332 12.5567 29.3332Z" stroke="#1A1A1A" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M27.2232 29.3332C27.9596 29.3332 28.5566 28.7362 28.5566 27.9998C28.5566 27.2635 27.9596 26.6665 27.2232 26.6665C26.4868 26.6665 25.8899 27.2635 25.8899 27.9998C25.8899 28.7362 26.4868 29.3332 27.2232 29.3332Z" stroke="#1A1A1A" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M1.88989 1.3335H7.22323L10.7966 19.1868C10.9185 19.8007 11.2524 20.3521 11.74 20.7446C12.2275 21.137 12.8375 21.3455 13.4632 21.3335H26.4232C27.049 21.3455 27.659 21.137 28.1465 20.7446C28.634 20.3521 28.968 19.8007 29.0899 19.1868L31.2232 8.00016H8.55656" stroke="#1A1A1A" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </a></li>
	        </ul>
		</div>
    </div>
    

    <div class="hd_sch_wr">
        <button class="ham gnb_menu_close_btn seach_close_btn">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="close">
                    <mask id="mask0_1117_17928" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="-3" y="-3" width="46" height="46">
                        <rect id="Bounding box" height="40" width="40" fill="#000" stroke="#000" stroke-width="5" ></rect>
                    </mask>
                </g>
                <g mask="url(#mask0_1117_17928)">
                    <path id="close_2" d="M10.6664 31.0893L8.91016 29.3331L18.2435 19.9997L8.91016 10.6664L10.6664 8.91016L19.9997 18.2435L29.3331 8.91016L31.0893 10.6664L21.756 19.9997L31.0893 29.3331L29.3331 31.0893L19.9997 21.756L10.6664 31.0893Z" fill="#ffffff" stroke="#ffffff" stroke-width="5"></path>
                </g>
            </svg>
        </button>
        <fieldset id="hd_sch">
            <legend>사이트 내 전체검색</legend>
            <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
                <input type="hidden" name="sfl" value="wr_subject||wr_content">
                <input type="hidden" name="sop" value="and">
                <label for="sch_stx" class="sound_only">검색어 필수</label>
                <input type="text" name="stx" id="sch_stx" maxlength="20" placeholder="Search">
                <button type="submit" id="sch_submit" value="검색"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
            </form>

            <script>
                function fsearchbox_submit(f)
                    {
                        var stx = f.stx.value.trim();
                            if (stx.length < 2) {
                                alert("검색어는 두글자 이상 입력하십시오.");
                                f.stx.select();
                                f.stx.focus();
                                return false;
                        }

                            // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                        var cnt = 0;
                        for (var i = 0; i < stx.length; i++) {
                            if (stx.charAt(i) == ' ')
                                cnt++;
                        }

                        if (cnt > 1) {
                        alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                        f.stx.select();
                        f.stx.focus();
                        return false;
                    }
                    f.stx.value = stx;

                    return true;
                }
            </script>

        </fieldset>
            
            <?php echo popular('theme/basic'); // 인기검색어, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정  ?>
            
    </div>
    <div id="gnb_all">
        <!-- <h2>전체메뉴</h2> -->
         <ul class="gnb_al_li">
            <li><a href="<?php echo G5_URL ?>">Home</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/register.php">Join</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/login.php">Login</a></li>
            <li>
                <a href="<?php echo G5_URL ?>">cart</a>
            </li>
         </ul>
        <button class="ham gnb_menu_close_btn">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="close">
                    <mask id="mask0_1117_17928" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="-3" y="-3" width="46" height="46">
                        <rect id="Bounding box" height="40" width="40" fill="#ffffff" stroke="#ffffff" stroke-width="5" ></rect>
                    </mask>
                </g>
                <g mask="url(#mask0_1117_17928)">
                    <path id="close_2" d="M10.6664 31.0893L8.91016 29.3331L18.2435 19.9997L8.91016 10.6664L10.6664 8.91016L19.9997 18.2435L29.3331 8.91016L31.0893 10.6664L21.756 19.9997L31.0893 29.3331L29.3331 31.0893L19.9997 21.756L10.6664 31.0893Z" fill="#ffffff" stroke="#ffffff" stroke-width="5"></path>
                </g>
            </svg>
        </button>


        <div class="ham_nav">
            <ul class="gnb_al_ul">
            <?php
                    $menu_datas = get_menu_db(0, true);
                    $gnb_zindex = 999; // gnb_1dli z-index 값 설정용
                    $i = 0;
                    foreach( $menu_datas as $row ){
                        if( empty($row) ) continue;
                        $add_class = (isset($row['sub']) && $row['sub']) ? 'gnb_al_li_plus' : '';
                    ?>
                    <li class="gnb_1dli <?php echo $add_class; ?>" style="z-index:<?php echo $gnb_zindex--; ?>">
                        <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="gnb_1da"><?php echo $row['me_name'] ?></a>
                        <?php
                        $k = 0;
                        foreach( (array) $row['sub'] as $row2 ){

                            if( empty($row2) ) continue; 

                            if($k == 0)
                                echo '<span class="bg">하위분류</span><div class="gnb_2dul"><ul class="gnb_2dul_box">'.PHP_EOL;
                        ?>
                            <li class="gnb_2dli"><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>" class="gnb_2da"><?php echo $row2['me_name'] ?></a></li>
                        <?php
                        $k++;
                        }   //end foreach $row2

                        if($k > 0)
                            echo '</ul></div>'.PHP_EOL;
                        ?>
                    </li>
                    <?php
                    $i++;
                    }   //end foreach $row

                    if ($i == 0) {  ?>
                        <li class="gnb_empty">메뉴 준비 중입니다.<?php if ($is_admin) { ?> <a href="<?php echo G5_ADMIN_URL; ?>/menu_list.php">관리자모드 &gt; 환경설정 &gt; 메뉴설정</a>에서 설정하실 수 있습니다.<?php } ?></li>
                    <?php } ?>
            </ul>
        </div>    
    </div>


    <script>
        $(function(){
            $(".gnb_menu_btn").click(function(){
                $("body").addClass('expand')
            });
            $(".gnb_menu_close_btn, #gnb_all_bg").click(function(){
                $("body").removeClass('expand')
            });
            $(".gnb_1dli .bg").click(function(e){
            e.preventDefault();
            
            let $li = $(this).closest(".gnb_1dli");

            if($li.hasClass("open")) {
                $li.removeClass("open");
            } else {
                $(".gnb_1dli").removeClass("open");
                $li.addClass("open");
            }
        });
    
        $('#hd_qnb .gnb_1dli').mouseenter(function() {
            $('#hd_qnb .gnb_1dli').removeClass('active');
            $(this).addClass('active'); 
        });

        $('#hd_qnb').mouseleave(function(){
            $('#hd_qnb .gnb_1dli').removeClass('active');
        });

        $("#searchIcon").click(function(e){
            e.preventDefault();
            $("body").toggleClass("expand2");
            $(this).toggleClass("active");
        });

        // 검색 닫기 버튼 클릭 시 닫힘
        $(".seach_close_btn").click(function(e){
            e.preventDefault();
            $("body").removeClass("expand2");
            $("#searchIcon").removeClass("active");
        });
        list.addEventListener("click", function(e){
            const btn = e.target.closest(".recent_del");
            if(!btn) return;

            // 이벤트 전파 막기
            e.stopPropagation();

            const li = btn.closest("li");
            if(li) li.remove(); // 화면에서 즉시 제거

            const key = btn.dataset.key;
            keywords = keywords.filter(k => k !== key);
            localStorage.setItem("recentSearch", JSON.stringify(keywords));
        });


        // body 아무 데나 클릭하면 닫힘 (단, 검색창/아이콘 제외)
        $(document).click(function(e){
            if (!$(e.target).closest('#searchIcon, .hd_sch_wr').length) {
                $("body").removeClass("expand2");
                $("#searchIcon").removeClass("active");
                }
        
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
        // 검색 폼이 있을 때만 실행
        const searchForm = document.querySelector('form[name="fsearchbox"], form[name="fsearch"]');
        if (!searchForm) return;

        console.log("[Head] search form detected");

        // 검색 submit 이벤트
        searchForm.addEventListener("submit", function(e) {
            const input = searchForm.querySelector('input[name="stx"]');
            if (!input) return;

            const stx = input.value.trim();
            console.log("[Head] submitted stx:", stx);

            if (stx.length < 2) {
                alert("검색어는 두 글자 이상 입력하세요.");
                input.focus();
                e.preventDefault();
                return false;
            }

        if ((stx.match(/ /g) || []).length > 1) {
            alert("검색어에 공백은 한 개만 입력 가능합니다.");
            input.focus();
            e.preventDefault();
            return false;
        }

        // 최근검색어 저장
        try {
            let keywords = JSON.parse(localStorage.getItem("recentSearch")) || [];
            console.log("[Head] localStorage before update:", keywords);

            keywords = keywords.filter(word => word !== stx);
            keywords.unshift(stx);
            keywords = keywords.slice(0, 7);

            localStorage.setItem("recentSearch", JSON.stringify(keywords));
            console.log("[Head] updated recentSearch array:", keywords);
        } catch(err) {
            console.error("[Head] localStorage error:", err);
        }
    });

    

    // 초기 렌더링
    renderRecentSearches();

    
    });

    </script>
</div>
<!-- } 상단 끝 -->


<hr>

<!-- 콘텐츠 시작 { -->
<div id="wrapper">
    <div id="container_wr">
   
    <div id="container">
        <?php if (!defined("_INDEX_")) { ?><h2 id="container_title"><span title="<?php echo get_text($g5['title']); ?>"><?php echo get_head_title($g5['title']); ?></span></h2><?php }