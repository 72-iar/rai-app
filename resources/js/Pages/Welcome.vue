<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, onUnmounted } from "vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

onMounted(() => {
  function toggleScrolled() {
    const body = document.querySelector("body");
    const header = document.querySelector("#header");

    if (!header?.classList.contains("scroll-up-sticky") &&
        !header?.classList.contains("sticky-top") &&
        !header?.classList.contains("fixed-top")) return;

    window.scrollY > 100 ? body.classList.add("scrolled") : body.classList.remove("scrolled");
  }

  function toggleScrollTop() {
    let scrollTop = document.querySelector(".scroll-top");
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add("active") : scrollTop.classList.remove("active");
    }
  }

  function scrollToTop(event) {
    event.preventDefault();
    window.scrollTo({ top: 0, behavior: "smooth" });
  }

  function navmenuScrollspy() {
    let navLinks = document.querySelectorAll(".navmenu a");

    navLinks.forEach((link) => {
      if (!link.hash) return;
      let section = document.querySelector(link.hash);
      if (!section) return;
      let position = window.scrollY + 200;

      if (position >= section.offsetTop && position <= section.offsetTop + section.offsetHeight) {
        document.querySelectorAll(".navmenu a.active").forEach((activeLink) => activeLink.classList.remove("active"));
        link.classList.add("active");
      } else {
        link.classList.remove("active");
      }
    });
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

  // Initialize AOS (since it's already loaded in app.blade.php)
  if (window.AOS) {
    window.AOS.init({
      duration: 600,
      easing: "ease-in-out",
      once: true,
      mirror: false,
    });
  }

  // Event Listeners
  window.addEventListener("scroll", toggleScrolled);
  window.addEventListener("scroll", toggleScrollTop);
  window.addEventListener("scroll", navmenuScrollspy);
  window.addEventListener("load", toggleScrolled);
  window.addEventListener("load", toggleScrollTop);
  window.addEventListener("load", fixHashScroll);
  window.addEventListener("load", navmenuScrollspy);

  // Scroll top button
  let scrollTop = document.querySelector(".scroll-top");
  scrollTop?.addEventListener("click", scrollToTop);

  // Cleanup on unmount
  onUnmounted(() => {
    window.removeEventListener("scroll", toggleScrolled);
    window.removeEventListener("scroll", toggleScrollTop);
    window.removeEventListener("scroll", navmenuScrollspy);
    window.removeEventListener("load", toggleScrolled);
    window.removeEventListener("load", toggleScrollTop);
    window.removeEventListener("load", fixHashScroll);
    window.removeEventListener("load", navmenuScrollspy);
    scrollTop?.removeEventListener("click", scrollToTop);
  });
});
</script>

<template>
<Head title="Welcome" />
        <header id="header" class="header d-flex align-items-center fixed-top">
            <div class="container-fluid container-xl position-relative d-flex align-items-center">
                <a href="#" class="logo d-flex align-items-center me-auto">
                    <img src="/public/images/gurr-logo.png" alt="ico">
                    <h1 class="sitename">Gurr</h1>
                </a>
                <nav id="navmenu" class="navmenu">
                    <div class="flex items-center justify-end" v-if="canLogin">
                    <a href="#banner" class="mr-2 hover:text-indigo-200">Home</a>
                    <a href="#services" class="mr-2 hover:text-indigo-200">Services</a>
                    <a href="#contact" class="mr-2 hover:text-indigo-200">Contact</a>

                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class=" hover:text-indigo-200">
                        Dashboard
                    </Link>

                    <template v-else>
                        <Link :href="route('login')" class="mr-2 hover:text-indigo-200">
                            Log in
                        </Link>

                        <Link v-if="canRegister" :href="route('register')" class=" hover:text-indigo-200">
                            Register
                        </Link>
                    </template>
                </div>
                </nav>
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
                                    <input type="text" name="name" id="name-field" class="form-control" required="">
                                </div>

                                <div class="col-md-6">
                                    <label for="email-field" class="pb-2">Your Email</label>
                                    <input type="email" class="form-control" name="email" id="email-field" required="">
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
