<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from "vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

const mobileMenuOpen = ref(false);
const scrollTopVisible = ref(false);

const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value;
};

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
};

onMounted(() => {
    function toggleScrolled() {
        const body = document.querySelector("body");
        window.scrollY > 100 ? body.classList.add("scrolled") : body.classList.remove("scrolled");
        scrollTopVisible.value = window.scrollY > 100;
    }

    function toggleScrollTop() {
        let scrollTop = document.querySelector(".scroll-top");
        if (scrollTop) {
            window.scrollY > 100 ? scrollTop.classList.add("active") : scrollTop.classList.remove("active");
        }
    }

    function fixHashScroll() {
        if (window.location.hash) {
            let section = document.querySelector(window.location.hash);
            if (section) {
                setTimeout(() => {
                    let scrollMarginTop = getComputedStyle(section).scrollMarginTop;
                    window.scrollTo({
                        top: section.offsetTop - parseInt(scrollMarginTop),
                        behavior: "smooth",
                    });
                }, 100);
            }
        }
    }

    if (window.AOS) {
        window.AOS.init({
            duration: 600,
            easing: "ease-in-out",
            once: true,
            mirror: false,
        });
    }

    window.addEventListener("scroll", toggleScrolled);
    window.addEventListener("scroll", toggleScrollTop);
    window.addEventListener("load", toggleScrolled);
    window.addEventListener("load", toggleScrollTop);
    window.addEventListener("load", fixHashScroll);

    onUnmounted(() => {
        window.removeEventListener("scroll", toggleScrolled);
        window.removeEventListener("scroll", toggleScrollTop);
        window.removeEventListener("load", toggleScrolled);
        window.removeEventListener("load", toggleScrollTop);
        window.removeEventListener("load", fixHashScroll);
    });
});
</script>

<template>
    <Head title="Welcome" />
    <header id="header" class="bg-white shadow-md fixed top-0 w-full z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="#" class="flex items-center">
                <img src="/public/images/gurr-logo.png" alt="Gurr Logo" class="h-10">
                <h1 class="ml-2 text-xl font-semibold text-gray-900">Gurr</h1>
            </a>
            
            <!-- Desktop Menu -->
            <nav class="hidden md:flex space-x-6" v-if="canLogin">
                <a href="#banner" class="text-gray-700 hover:text-indigo-500">Home</a>
                <a href="#services" class="text-gray-700 hover:text-indigo-500">Services</a>
                <a href="#contact" class="text-gray-700 hover:text-indigo-500">Contact</a>
                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-gray-700 hover:text-indigo-500">Dashboard</Link>
                <template v-else>
                    <Link :href="route('login')" class="text-gray-700 hover:text-indigo-500">Log in</Link>
                    <Link v-if="canRegister" :href="route('register')" class="text-gray-700 hover:text-indigo-500">Register</Link>
                </template>
            </nav>
            
            <!-- Mobile Menu Button -->
            <button @click="toggleMobileMenu" class="md:hidden focus:outline-none">
                <svg v-if="!mobileMenuOpen" class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg v-else class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div v-if="mobileMenuOpen" class="md:hidden bg-white border-t border-gray-200 w-full absolute left-0">
            <div class="flex flex-col space-y-2 py-4 px-6">
                <a href="#banner" class="text-gray-700 hover:text-indigo-500" @click="toggleMobileMenu">Home</a>
                <a href="#services" class="text-gray-700 hover:text-indigo-500" @click="toggleMobileMenu">Services</a>
                <a href="#contact" class="text-gray-700 hover:text-indigo-500" @click="toggleMobileMenu">Contact</a>
                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-gray-700 hover:text-indigo-500" @click="toggleMobileMenu">Dashboard</Link>
                <template v-else>
                    <Link :href="route('login')" class="text-gray-700 hover:text-indigo-500" @click="toggleMobileMenu">Log in</Link>
                    <Link v-if="canRegister" :href="route('register')" class="text-gray-700 hover:text-indigo-500" @click="toggleMobileMenu">Register</Link>
                </template>
            </div>
        </div>
    </header>
        <!-- Banner Section -->
        <section id="banner" class="banner section dark-background">
            <div class="overlay"></div> <!-- Added overlay div -->
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                        <h1>From Idea to Reality</h1>
                        <p>Bringing Your Ideas to Life with Innovative Solutions and Seamless Experiences!</p>
                        <div class="d-flex">
                            <a href="#services" class="btn-get-started">Get Started</a>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 banner-img" data-aos="zoom-out" data-aos-delay="200">
                        <img src="/public/images/gurr-hollow-tilted-logo.png" class="img-fluid animated" alt="gurr-hollow-logo">
                    </div>
                </div>
            </div>
        </section>
        <!-- /Banner Section -->
         
        <!-- Services Section -->
        <section id="services" class="services section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Services</h2>
                <p>Offering tailored solutions to meet your goals.</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">
                    <div class="col-xl-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <img src="/public/images/web-development.png" alt="" width="80">
                            </div>
                            <h4><a href="" class="stretched-link">Web Development</a></h4>
                            <p>Build modern, responsive websites tailored to your business needs.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <img src="/public/images/mobile-development.png" alt="" width="80">
                            </div>
                            <h4><a href="" class="stretched-link">Mobile Development</a></h4>
                            <p>Create intuitive mobile apps that deliver seamless user experiences.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <img src="/public/images/project-management.png" alt="" width="80">
                            </div>
                            <h4><a href="" class="stretched-link">Project Management</a></h4>
                            <p>Efficiently manage projects to ensure timely delivery and quality results.</p>
                        </div>
                    </div><!-- End Service Item -->
                </div>
            </div>

        </section><!-- /Services Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Feel free to reach out to us for any inquiries or assistance.</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-5">
                        <div class="info-wrap">
                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                                <i class="bi bi-geo-alt flex-shrink-0"></i>
                                <div>
                                    <h3>Address</h3>
                                    <p>Lower Calajoan, Minglanilla, Cebu</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                                <i class="bi bi-telephone flex-shrink-0"></i>
                                <div>
                                    <h3>Call Us</h3>
                                    <p>0912 345 6789</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                                <i class="bi bi-envelope flex-shrink-0"></i>
                                <div>
                                    <h3>Email Us</h3>
                                    <p>gurr1217@gmail.com</p>
                                </div>
                            </div><!-- End Info Item -->

                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d313.88904852268774!2d123.80532786162314!3d10.243248312165964!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2sph!4v1737629299297!5m2!1sen!2sph" 
                                frameborder="0" 
                                style="border:0; width: 100%; height: 270px;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <form action="" method="" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <label for="name-field" class="pb-2">Your Name</label>
                                    <input type="text" name="name" id="name-field" class="form-control" required="" autocomplete="name">
                                </div>

                                <div class="col-md-6">
                                    <label for="email-field" class="pb-2">Your Email</label>
                                    <input type="email" class="form-control" name="email" id="email-field" required="" autocomplete="email">
                                </div>

                                <div class="col-md-12">
                                    <label for="subject-field" class="pb-2">Subject</label>
                                    <input type="text" class="form-control" name="subject" id="subject-field" required="">
                                </div>

                                <div class="col-md-12">
                                    <label for="message-field" class="pb-2">Message</label>
                                    <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <button type="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- End Contact Form -->
                </div>
            </div>
        </section>
        <!-- /Contact Section -->

        <footer id="footer" class="footer">
            <div class="container copyright text-center mt-4">
                <div class="social-links d-flex row gy-4">
                    <div class = "social-links-container col-xl-3 col-md-6 d-flex justify-content-center">
                        <a href=""><i class="bi bi-discord"></i></a>
                        Discord
                    </div>

                    <div class = "social-links-container col-xl-3 col-md-6 d-flex justify-content-center">
                        <a href=""><i class="bi bi-facebook"></i></a>
                        Facebook
                    </div>

                    <div class = "social-links-container col-xl-3 col-md-6 d-flex justify-content-center">
                        <a href=""><i class="bi bi-instagram"></i></a>
                        Instagram
                    </div>

                    <div class = "social-links-container col-xl-3 col-md-6 d-flex justify-content-center">
                        <a href=""><i class="bi bi-linkedin"></i></a>
                        LinkedIn
                    </div>
                </div>
                <p><span>All Rights Reserved 2025</span></p>
            </div>
        </footer>
</template>
