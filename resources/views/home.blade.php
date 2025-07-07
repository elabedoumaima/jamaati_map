@extends('layouts.app')

@section('title', 'جماعتي - الصفحة الرئيسية')

@section('content')
    <!-- cursor -->
    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>
    
    <!-- hero -->
    <div class="hero">
        <video autoplay loop muted plays-inline class="back-video">
            <source src="{{ asset('images/laayouneCity.mp4') }}" type="video/mp4">
        </video>
        <nav>
            <img src="{{ asset('images/logo.png') }}" class="logo" alt="Logo">
            <div class="menu-toggle" id="menuToggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul id="navLinks">
                <li><a href="{{ route('home') }}">الصفحة الرئيسية</a></li>
                <li><a href="#about">من نحن</a></li>
                <li><a href="#squares">الساحات العمومية</a></li>
                <li><a href="#faq">الأسئلة الشائعة</a></li>
                <li><a href="#comments">ارسل لنا تعليق</a></li>
            </ul>
        </nav>
        <div class="content">
            <h1><em>JAMAATI MAP</em></h1>
            <a href="#squares">explore</a>
        </div>
    </div>

    <!-- description -->
    <section class="container" id="about">
        <div class="title">تعرف علينا</div>
        <div class="main-section">
            <div class="main-content">
                <div class="description">
                    <span style="color: #f6313f; font-family: initial; font-weight: 700;">
                        <em>Jamaati Map</em>
                    </span>
                    هو موقع يتيح لك فرصة اكتشاف الساحات العمومية والملاعب الرياضية في مدينة العيون بكل سهولة وراحة. من خلال واجهته البسيطة والعملية، يمكنك التعرف على مواقع هذه الأماكن بدقة، مما يسهل عليك التخطيط لزياراتك أو ممارسة نشاطاتك الرياضية في أفضل الأماكن المتوفرة في المدينة.
                </div>
                <div class="image-placeholder">
                    <img src="{{ asset('images/ds-laayoune.png') }}" alt="صورة توضيحية" class="main-image" />
                    <img src="{{ asset('images/خريطة.png') }}" alt="صورة جانبية 1" class="small-image small-top-left">
                    <img src="{{ asset('images/hamdi.jpg') }}" alt="صورة جانبية 2" class="small-image small-bottom-right">
                </div>
            </div>
        </div>
    </section>

    <!-- slider -->
    <section class="container" id="squares">
        <div class="title">الساحات العمومية</div>
        <div class="slider-container">
            <div class="slides-wrapper-padding">
                <div class="slides-wrapper">
                    @foreach($squares as $index => $square)
                        <div class="slide {{ $index === 0 ? 'active' : '' }}">
                            <div class="slide-content">
                                <h2>{{ $square['name'] }}</h2>
                                <p>{{ $square['description'] }}</p>
                            </div>
                            <div class="slide-image">
                                <img src="{{ asset('images/' . $square['image']) }}" alt="{{ $square['name'] }}" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="navigation">
                <div class="nav-arrow prev" onclick="changeSlide(-1)">‹</div>
                <div class="dots-container">
                    @foreach($squares as $index => $square)
                        <div class="dot {{ $index === 0 ? 'active' : '' }}" 
                             data-number="{{ $index + 1 }}" 
                             onclick="currentSlide({{ $index + 1 }})"></div>
                    @endforeach
                </div>
                <div class="nav-arrow next" onclick="changeSlide(1)">›</div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="container" id="faq">
        <h1 class="title">الأسئلة الشائعة</h1>
        <div class="faq-container">
            @php
                $faqs = [
                    [
                        'question' => 'ما هو موقع Jamaati Map ؟',
                        'answer' => 'Jamaati Map هو منصة تفاعلية تساعدك في استكشاف الساحات العمومية والملاعب بمدينة العيون بسهولة عبر خريطة ذكية وواضحة.'
                    ],
                    [
                        'question' => 'هل يمكنني معرفة موقع ساحة أو ملعب معين؟',
                        'answer' => 'نعم، يمكنك البحث أو تصفح الخريطة للحصول على الموقع الدقيق لأي ساحة أو ملعب مسجل في النظام.'
                    ],
                    [
                        'question' => 'هل جميع الساحات والملاعب في العيون موجودة في الموقع؟',
                        'answer' => 'نعمل على تحديث قاعدة البيانات باستمرار، وقد لا تكون كل الساحات مدرجة حاليًا، لكننا نسعى لتغطية كل الأماكن مستقبلاً.'
                    ],
                    [
                        'question' => 'هل الموقع مجاني؟',
                        'answer' => 'نعم، جميع خدمات Jamaati Map مجانية ومفتوحة للجميع.'
                    ],
                    [
                        'question' => 'كيف يمكنني الإبلاغ عن خطأ في موقع أو اسم ساحة؟',
                        'answer' => 'يمكنك استعمال صفحة "اتصل بنا" أو النموذج المخصص للتبليغ عن أي معلومات خاطئة أو ناقصة.'
                    ],
                    [
                        'question' => 'هل يمكنني إضافة ساحة أو ملعب جديد؟',
                        'answer' => 'حالياً لا يمكن للمستخدمين إضافة مواقع مباشرة، لكن يمكنك اقتراح ذلك من خلال التواصل معنا.'
                    ]
                ];
            @endphp
            
            @foreach($faqs as $faq)
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>{{ $faq['question'] }}</span>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>{{ $faq['answer'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Comments -->
   <section class="container" id="comments">
        <div class="commu-notification" id="notification"></div>
        <div class="title">اكتب تعليقك<p style="color: #666; font-size: 20px;">شاركنا رأيك وأفكارك</p></div>
        <div class="commu-container">
            <!-- نموذج التعليق -->
            <form class="commu-comment-form" id="commentForm">
                @csrf
                <div class="commu-form-row">
                    <div class="commu-form-group">
                        <label for="author_name">الاسم</label>
                        <input type="text" id="author_name" name="author_name" placeholder="اكتب اسمك" required />
                        <div class="error-message" id="author_name_error"></div>
                    </div>
                    <div class="commu-form-group">
                        <label for="author_email">البريد الإلكتروني</label>
                        <input type="email" id="author_email" name="author_email" placeholder="example@email.com" required />
                        <div class="error-message" id="author_email_error"></div>
                    </div>
                </div>

                <div class="commu-form-group">
                    <label for="content">التعليق</label>
                    <textarea id="content" name="content" placeholder="اكتب تعليقك هنا..." required></textarea>
                    <div class="error-message" id="content_error"></div>
                </div>

                <div class="commu-form-features">
                    <div class="commu-emoji-picker">
                        <button type="button" class="commu-emoji-btn" data-emoji="😀">😀</button>
                        <button type="button" class="commu-emoji-btn" data-emoji="😍">😍</button>
                        <button type="button" class="commu-emoji-btn" data-emoji="👍">👍</button>
                        <button type="button" class="commu-emoji-btn" data-emoji="❤️">❤️</button>
                        <button type="button" class="commu-emoji-btn" data-emoji="🔥">🔥</button>
                        <button type="button" class="commu-emoji-btn" data-emoji="💯">💯</button>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <button type="submit" class="commu-submit-btn">🚀 نشر التعليق</button>
                </div>
            </form>

            <!-- قسم التعليقات -->
            <div class="commu-simple-comments-section">
                <h2 class="commu-simple-comments-title" id="commentsToggle">
                    التعليقات
                    <span class="commu-accordion-icon rotated">🔼</span>
                </h2>

                <div class="commu-comments-content collapsed" id="commentsContent">
                    <div class="commu-comments-count">
                        عدد التعليقات: <span id="commentsCount">{{ $comments->count() }}</span>
                    </div>

                    <div id="commentsList">
                        @forelse($comments as $comment)
                            <div class="commu-simple-comment" data-comment-id="{{ $comment->id }}">
                                <div class="commu-comment-header">
                                    <span class="commu-comment-author">{{ $comment->author_name }}</span>
                                    <span class="commu-comment-date">{{ $comment->formatted_time }}</span>
                                </div>
                                <div class="commu-comment-content">{{ $comment->content }}</div>
                            </div>
                        @empty
                            <div class="commu-no-comments">
                                <p>لا توجد تعليقات حتى الآن</p>
                                <p>كن أول من يضيف تعليقاً جديداً! ✨</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="company-info">
                    <h3>Jamaati Map</h3>
                    <p>نُبدع في تقديم خدمات متكاملة ترتقي بتجربتكم.</p>
                </div>

                <div class="quick-links">
                    <a href="{{ route('home') }}">الصفحة الرئيسية</a>
                    <a href="#about">من نحن</a>
                    <a href="#squares">الساحات العمومية</a>
                    <a href="#comments">ارسل لنا تعليق</a>
                    <a href="#faq">الأسئلة الشائعة</a>
                </div>

                <div class="social-links">
                    <a style="background: white;" href="https://www.facebook.com" target="_blank" aria-label="Facebook">
                        <i style="color: rgb(74, 97, 242); "  class="fab fa-facebook-f"></i>
                    </a>
                    <a style="background: white;" href="https://www.instagram.com" target="_blank" aria-label="Instagram">
                        <i style="color: rgb(253, 95, 95); " class="fab fa-instagram"></i>
                    </a>
                    <a style="background: white;" href="https://www.twitter.com" target="_blank" aria-label="Twitter">
                        <i style="color: rgb(74, 97, 242); " class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 جميع الحقوق محفوظة - jamaati map</p>
            </div>
        </div>
    </footer>
@endsection