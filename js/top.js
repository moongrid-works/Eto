$(function () {

  /* =============================
     定数定義
     ・マジックナンバーを避ける
     ・後からの調整を容易にする
  ============================= */
  const BREAKPOINT = 768;        // SP判定用ブレイクポイント
  const PC_BREAKPOINT = 1200;   // PC判定用ブレイクポイント
  const RESIZE_DELAY = 200;     // リサイズイベントのデバウンス時間
  
  // スライダー要素
  const $newItemSlider = $('.new-item__slider');
  const $hamburgerWrapper = $('.hamburger-wrapper'); // ハンバーガーメニューのラッパー
  const $newsSlider = $('.news-slider'); // ニューススライダー

  /* =============================
     News Slider（お知らせ）
     ・常時自動再生
     ・ホバーで停止しない
     ・SlickはSPでは操作性が悪いため、PC幅のみ有効化
  ============================= */
  function initNewsSlider() {
    $('.news-slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 3000,
      arrows: false,
      dots: false,
      pauseOnHover: false,
      infinite: true
    });
  }

  /* =============================
     New Item Slider
     ・PCサイズのみ Slick を有効化
     ・SPでは unslick して通常表示
  ============================= */
  function initNewItemSlider() {
    if ($(window).width() >= PC_BREAKPOINT) {
      // 未初期化の場合のみ初期化
      if (!$newItemSlider.hasClass('slick-initialized')) {
        $newItemSlider.slick({
          slidesToShow: 4,
          slidesToScroll: 1,
          autoplay: true,
          autoplaySpeed: 2000,
          arrows: true,
          dots: true,
          prevArrow: '<button class="slick-prev" aria-label="前へ">‹</button>',
          nextArrow: '<button class="slick-next" aria-label="次へ">›</button>',
          responsive: [
            { breakpoint: 1600, settings: { slidesToShow: 3 } },
            { breakpoint: 1400, settings: { slidesToShow: 2 } }
          ]
        });
      }
    } else {
      // SPサイズでは Slick を解除
      if ($newItemSlider.hasClass('slick-initialized')) {
        $newItemSlider.slick('unslick');
      }
    }
  }

  /* =============================
     ニューススライダーの高さを取得して、ハンバーガーメニュー位置を調整
  ============================= */
  function adjustHamburgerPosition() {
    const sliderHeight = $newsSlider.outerHeight();  // ニューススライダーの高さを取得

    // ニューススライダーの高さが変わった場合にボタンの位置を調整
    const HAMBURGER_OFFSET = 20;
$hamburgerWrapper.css('top', sliderHeight + HAMBURGER_OFFSET);
  // 余白とスライダーの高さを合算
  }

  // 初期位置調整
  adjustHamburgerPosition();

  // スライダーの高さが変わるたびに再調整
  $(window).resize(function() {
    adjustHamburgerPosition();
  });

  /* =============================
     Drawer（Vanilla JS）
  ============================= */
const hamburger = document.getElementById("hamburger");
const drawer = document.getElementById("drawer");
const overlay = document.getElementById("drawer-overlay");
const body = document.body;

function openDrawer() {
  // ハンバーガーメニューのボタンが開いた状態（×）
  hamburger.querySelector(".hamburger").classList.add("open");
  hamburger.querySelector(".hamburger").setAttribute("aria-expanded", "true");

  drawer.classList.add("is-open");
  drawer.setAttribute("aria-hidden", "false");

  overlay.removeAttribute("hidden");
  overlay.setAttribute("aria-hidden", "false");
  overlay.style.display = "block";

  body.classList.add("no-scroll");
}

function closeDrawer() {
  // ハンバーガーメニューのボタンが元の状態（3本線）
  hamburger.querySelector(".hamburger").classList.remove("open");
  hamburger.querySelector(".hamburger").setAttribute("aria-expanded", "false");

  drawer.classList.remove("is-open");
  drawer.setAttribute("aria-hidden", "true");

  overlay.style.display = "none";
  overlay.setAttribute("hidden", "true");
  overlay.setAttribute("aria-hidden", "true");

  body.classList.remove("no-scroll");
}

function toggleDrawer() {
  if (drawer.classList.contains("is-open")) {
    closeDrawer();
  } else {
    openDrawer();
  }
}

// イベント登録
hamburger.addEventListener("click", toggleDrawer);
overlay.addEventListener("click", closeDrawer);
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape" && drawer.classList.contains("is-open")) {
    closeDrawer();
  }
});

  /* =============================
     Smooth Scroll（ページ内リンク）
  ============================= */
  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener("click", e => {
      const targetId = link.getAttribute("href");
      if (targetId !== "#" && targetId.startsWith("#")) {
        e.preventDefault();
        const targetEl = document.querySelector(targetId);
        if (targetEl) {
          // ヘッダーの高さを取得（なければ 0）
          const HEADER_HEIGHT = document.querySelector('.header')?.offsetHeight || 0;

          // ヘッダー分だけ上にずらした位置を計算
          const position = targetEl.offsetTop - HEADER_HEIGHT;

          window.scrollTo({
            top: position,
            behavior: "smooth"
          });
        }

        // ドロワーが開いていたら閉じる
        if (drawer.classList.contains("is-open")) {
          closeDrawer();
        }
      }
    });
  });
  
  /* =============================
     リサイズ対応（Slick再初期化）
  ============================= */
  let resizeTimer;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(initNewItemSlider, RESIZE_DELAY);
  });

  /* =============================
     現在地ナビ（aria-current）
  ============================= */
  const navLinks = document.querySelectorAll('.nav-top a');
  const sections = document.querySelectorAll('section');

  window.addEventListener('scroll', () => {
    let currentSectionId = '';

    sections.forEach(section => {
      const sectionTop = section.offsetTop;
      const sectionHeight = section.offsetHeight;

      if (pageYOffset >= sectionTop - sectionHeight / 3) { //sectionのだいたい上1/3くらいに来たら今見ているsectionとみなす
        currentSectionId = section.getAttribute('id');
      }
    });

    navLinks.forEach(link => {
      link.removeAttribute('aria-current');

      if (link.getAttribute('href') === `#${currentSectionId}`) {
        link.setAttribute('aria-current', 'true');
      }
    });
  });

  /* =============================
     初期化処理
  ============================= */
 initNewsSlider();
  initNewItemSlider();

}); 