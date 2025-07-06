// CURSOR
const cursor = document.querySelector('.custom-cursor__cursor');
const cursorTwo = document.querySelector('.custom-cursor__cursor-two');

document.addEventListener('mousemove', e => {
    const { clientX: x, clientY: y } = e;

    cursor.style.transform = `translate3d(calc(-50% + ${x}px), calc(-50% + ${y}px), 0)`;
    cursorTwo.style.left = `${x}px`;
    cursorTwo.style.top = `${y}px`;
});




// NAVEBAR
const menuToggle = document.getElementById('menuToggle');
const navLinks = document.getElementById('navLinks');

menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('show');     
    menuToggle.classList.toggle('open'); 
});





// SLIDER 
let currentSlideIndex = 1;
const totalSlides = 5;
let slideInterval;

const slidesWrapper = document.querySelector('.slides-wrapper');
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');

function showSlide(n) {
    if (n > totalSlides) currentSlideIndex = 1;
    if (n < 1) currentSlideIndex = totalSlides;

    const offset = -(currentSlideIndex - 1) * 100;
    slidesWrapper.style.transform = `translateX(${offset}%)`;

    slides.forEach((slide, i) => {
        if (i === currentSlideIndex - 1) {
            slide.classList.add('active');
        } else {
            slide.classList.remove('active');
        }
    });

    dots.forEach(dot => dot.classList.remove('active'));
    dots[currentSlideIndex - 1].classList.add('active');
}

function changeSlide(n) {
    currentSlideIndex += n;
    showSlide(currentSlideIndex);
    resetInterval();
}

function currentSlide(n) {
    currentSlideIndex = n;
    showSlide(currentSlideIndex);
    resetInterval();
}

function autoSlide() {
    currentSlideIndex++;
    showSlide(currentSlideIndex);
}

function resetInterval() {
    clearInterval(slideInterval);
    slideInterval = setInterval(autoSlide, 5000);
}

showSlide(currentSlideIndex);
slideInterval = setInterval(autoSlide, 5000);

const sliderContainer = document.querySelector('.slider-container');
sliderContainer.addEventListener('mouseenter', () => clearInterval(slideInterval));
sliderContainer.addEventListener('mouseleave', () => resetInterval());

document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') changeSlide(-1);
    if (e.key === 'ArrowRight') changeSlide(1);
});

let touchStartX = 0;
let touchEndX = 0;

sliderContainer.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
});

sliderContainer.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
});

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;

    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            changeSlide(1); 
        } else {
            changeSlide(-1); 
        }
    }
}




// ACCORDIO
function toggleFAQ(element) {
    const answer = element.nextElementSibling;
    const icon = element.querySelector('.faq-icon');

    // Close all other FAQs
    document.querySelectorAll('.faq-question').forEach(question => {
        if (question !== element) {
            question.classList.remove('active');
            question.nextElementSibling.classList.remove('active');
            question.querySelector('.faq-icon').textContent = '+';
        }
    });

    element.classList.toggle('active');
    answer.classList.toggle('active');

    if (element.classList.contains('active')) {
        icon.textContent = '×';
    } else {
        icon.textContent = '+';
    }
}

document.addEventListener('click', function (event) {
    if (!event.target.closest('.faq-item')) {
        document.querySelectorAll('.faq-question.active').forEach(question => {
            question.classList.remove('active');
            question.nextElementSibling.classList.remove('active');
            question.querySelector('.faq-icon').textContent = '+';
        });
    }
});

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        document.querySelectorAll('.faq-question.active').forEach(question => {
            question.classList.remove('active');
            question.nextElementSibling.classList.remove('active');
            question.querySelector('.faq-icon').textContent = '+';
        });
    }
});





// COMMUNTAIRE
// معالجة نموذج التعليقات
document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.getElementById('commentForm');
    const notification = document.getElementById('notification');
    const submitButton = commentForm.querySelector('.commu-submit-btn');
    const originalButtonText = submitButton.innerHTML;

    // إضافة الإيموجي للتعليق
    document.querySelectorAll('.commu-emoji-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const emoji = this.dataset.emoji;
            const contentTextarea = document.getElementById('content');
            contentTextarea.value += emoji;
            contentTextarea.focus();
        });
    });

    // معالجة إرسال النموذج
    commentForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        // إخفاء الأخطاء السابقة
        clearErrors();
        
        // تغيير نص الزر
        submitButton.innerHTML = '⏳ جاري الإرسال...';
        submitButton.disabled = true;

        try {
            const formData = new FormData(commentForm);
            
            const response = await fetch('/comments', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.success) {
                showNotification(data.message, 'success');
                commentForm.reset();
                
                // تحديث عدد التعليقات
                const commentsCount = document.getElementById('commentsCount');
                if (commentsCount) {
                    const currentCount = parseInt(commentsCount.textContent);
                    commentsCount.textContent = currentCount + 1;
                }
            } else {
                if (data.errors) {
                    showErrors(data.errors);
                } else {
                    showNotification(data.message || 'حدث خطأ أثناء إرسال التعليق', 'error');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
        } finally {
            // إعادة تعيين الزر
            submitButton.innerHTML = originalButtonText;
            submitButton.disabled = false;
        }
    });

    // عرض الإشعارات
    function showNotification(message, type) {
        notification.textContent = message;
        notification.className = `commu-notification ${type === 'success' ? 'success' : 'error'}`;
        notification.style.display = 'block';
        
        // إخفاء الإشعار بعد 5 ثوانٍ
        setTimeout(() => {
            notification.style.display = 'none';
        }, 5000);
    }

    // عرض الأخطاء
    function showErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            const errorElement = document.getElementById(field + '_error');
            if (errorElement) {
                errorElement.textContent = messages[0];
                errorElement.style.display = 'block';
            }
        }
    }

    // إخفاء الأخطاء
    function clearErrors() {
        document.querySelectorAll('.error-message').forEach(el => {
            el.style.display = 'none';
            el.textContent = '';
        });
    }

    // تبديل عرض التعليقات
    const commentsToggle = document.getElementById('commentsToggle');
    const commentsContent = document.getElementById('commentsContent');
    
    if (commentsToggle && commentsContent) {
        commentsToggle.addEventListener('click', function() {
            const icon = this.querySelector('.commu-accordion-icon');
            
            if (commentsContent.classList.contains('collapsed')) {
                commentsContent.classList.remove('collapsed');
                icon.textContent = '🔼';
                icon.classList.add('rotated');
            } else {
                commentsContent.classList.add('collapsed');
                icon.textContent = '🔽';
                icon.classList.remove('rotated');
            }
        });
    }
});

// إضافة تحقق من صحة البيانات في الوقت الفعلي
document.getElementById('author_name').addEventListener('input', function() {
    const value = this.value.trim();
    const errorElement = document.getElementById('author_name_error');
    
    if (value.length < 2) {
        errorElement.textContent = 'الاسم يجب أن يكون على الأقل حرفين';
        errorElement.style.display = 'block';
    } else {
        errorElement.style.display = 'none';
    }
});

document.getElementById('author_email').addEventListener('input', function() {
    const value = this.value.trim();
    const errorElement = document.getElementById('author_email_error');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (value && !emailRegex.test(value)) {
        errorElement.textContent = 'البريد الإلكتروني غير صحيح';
        errorElement.style.display = 'block';
    } else {
        errorElement.style.display = 'none';
    }
});

document.getElementById('content').addEventListener('input', function() {
    const value = this.value.trim();
    const errorElement = document.getElementById('content_error');
    const charCount = value.length;
    
    if (charCount < 5) {
        errorElement.textContent = 'التعليق قصير جداً';
        errorElement.style.display = 'block';
    } else if (charCount > 1000) {
        errorElement.textContent = 'التعليق طويل جداً';
        errorElement.style.display = 'block';
    } else {
        errorElement.style.display = 'none';
    }
});