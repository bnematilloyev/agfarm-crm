<?php
/* @var $this yii\web\View */
/* @var $users integer */
/* @var $clients integer */
/* @var $orders integer */
/* @var $awaits integer */

$this->title = "Asaxiy.uz";

?>
<!--hero section start-->

<section class="fullscreen-banner banner banner-2 p-0 overflow-hidden bg-contain bg-pos-r animatedBackground"
         data-bg-img="/images/bg/05.png">
    <div class="mouse-parallax" data-bg-img="/images/pattern/01.png"></div>
    <div class="h-100 bg-contain bg-pos-rb sm-bg-cover" data-bg-img="/images/bg/04.png">
        <div class="align-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="white-bg box-shadow px-5 py-5 sm-px-3 sm-py-3 xs-px-2 xs-py-2 bg-contain bg-pos-l radius"
                             data-bg-img="/images/bg/01.png">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-md-12 text-center">
                                    <img class="img-fluid animated zoomIn delay-2 duration-2"
                                         src="/images/banner/03.png" alt="">
                                </div>
                                <div class="col-lg-6 col-md-12 mt-5 mt-lg-0">
                                    <h1 class="mb-4 animated fadeInUp duration-2">workify <span class="font-w-5"> halol savdoga asoslangan muddatli to`lov </span>
                                        tizimi</h1>
                                    <p class="animated fadeInUp delay-1 duration-2">Mijozlaringiz halol yo`l va maqsad
                                        bilan mahsulotlaringiz uzoq muddatga xarid qilishsin</p>
                                    <div class="animated fadeInUp delay-2 duration-2">
                                        <a class="btn btn-theme" href="/contact"><span>Ariza qoldirish</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--hero section end-->


<!--body content start-->

<div class="page-content">

    <!--about start-->

    <section class="position-relative d-none">
        <div class="pattern-3">
            <img class="img-fluid rotateme" src="/images/pattern/03.png" alt="">
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12">
                    <div class="section-title">
                        <h6>About Us</h6>
                        <h2 class="title">We help our Digital marketing and SEO development.</h2>
                    </div>
                    <ul class="list-unstyled list-icon">
                        <li class="mb-3"><i class="flaticon-tick"></i> Mattis effic iturut magna pelle ntesque sit
                        </li>
                        <li class="mb-3"><i class="flaticon-tick"></i> Phasellus eget purus id felis dignissim
                            convallis
                        </li>
                        <li><i class="flaticon-tick"></i> Fusce enim nulla mollis eu metus in sagittis fringilla
                        </li>
                    </ul>
                </div>
                <div class="col-lg-7 col-md-12 mt-5 mt-lg-0">
                    <div class="owl-carousel no-pb" data-dots="false" data-items="2" data-sm-items="1"
                         data-autoplay="true">
                        <div class="item">
                            <div class="featured-item text-center style-2 mx-3 my-3">
                                <div class="featured-icon">
                                    <img class="img-fluid" src="/images/feature/01.png" alt="">
                                </div>
                                <div class="featured-title">
                                    <h5>Online Marketing</h5>
                                </div>
                                <div class="featured-desc">
                                    <p>Design must be functional, and futionality must translated into, and
                                        futionality must
                                        translated into.</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="featured-item text-center style-2 mx-3 my-3">
                                <div class="featured-icon">
                                    <img class="img-fluid" src="/images/feature/02.png" alt="">
                                </div>
                                <div class="featured-title">
                                    <h5>Data Analysis</h5>
                                </div>
                                <div class="featured-desc">
                                    <p>Design must be functional, and futionality must translated into, and
                                        futionality must
                                        translated into.</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="featured-item text-center style-2 mx-3 my-3">
                                <div class="featured-icon">
                                    <img class="img-fluid" src="/images/feature/03.png" alt="">
                                </div>
                                <div class="featured-title">
                                    <h5>SEO Optimization</h5>
                                </div>
                                <div class="featured-desc">
                                    <p>Design must be functional, and futionality must translated into, and
                                        futionality must
                                        translated into.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--about end-->


    <!--content start-->

    <section class="pt-0 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="counter style-2">
                        <img class="img-fluid" src="/images/counter/01.png" alt=""> <span class="count-number"
                                                                                          data-to="<?= $users ?>"
                                                                                          data-speed="10000"><?= $users ?></span>
                        <h5><?= Yii::t('app', 'Users') ?></h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 mt-5 mt-sm-0">
                    <div class="counter style-2">
                        <img class="img-fluid" src="/images/counter/02.png" alt=""> <span class="count-number"
                                                                                          data-to="<?= $clients ?>"
                                                                                          data-speed="10000"><?= $clients ?></span>
                        <h5><?= Yii::t('app', 'Customers') ?></h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 mt-5 mt-md-0">
                    <div class="counter style-2">
                        <img class="img-fluid" src="/images/counter/03.png" alt=""> <span class="count-number"
                                                                                          data-to="<?= $orders ?>"
                                                                                          data-speed="10000"><?= $orders ?></span>
                        <h5><?= Yii::t('app', 'Leasings') ?></h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 mt-5 mt-md-0">
                    <div class="counter style-2">
                        <img class="img-fluid" src="/images/counter/04.png" alt=""> <span class="count-number"
                                                                                          data-to="<?= $awaits ?>"
                                                                                          data-speed="10000"><?= $awaits ?></span>
                        <h5><?= Yii::t('app', 'Tranzaksiyalar') ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--content end-->


    <!--how it work start-->

    <section class="position-relative custom-pt-5 bg-contain bg-pos-r d-none" data-bg-img="/images/bg/02.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 image-column bg-contain bg-pos-l" data-bg-img="/images/pattern/07.png">
                    <img class="img-fluid" src="/images/about/01.png" alt="">
                </div>
                <div class="col-lg-6 col-md-12 ms-auto mt-5 mt-lg-0 ps-lg-5">
                    <div class="section-title">
                        <h6>How It Work</h6>
                        <h2 class="title">Three Step For Started Working Process</h2>
                    </div>
                    <div class="work-process style-2">
                        <div class="work-process-inner"><span class="step-num" data-bg-color="#ff7810">01</span>
                            <h4>Research Project</h4>
                            <p class="mb-0">Fusce enim nulla mollis eu metus in sagittis fringilla lnim nulla</p>
                        </div>
                    </div>
                    <div class="work-process style-2 mt-5">
                        <div class="work-process-inner"><span class="step-num" data-bg-color="#ff156a">02</span>
                            <h4>Project Targeting</h4>
                            <p class="mb-0">Fusce enim nulla mollis eu metus in sagittis fringilla lnim nulla</p>
                        </div>
                    </div>
                    <div class="work-process style-2 mt-5">
                        <div class="work-process-inner"><span class="step-num" data-bg-color="#ffb72f">03</span>
                            <h4>Reach Target</h4>
                            <p class="mb-0">Fusce enim nulla mollis eu metus in sagittis fringilla lnim nulla</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--how it work end-->


    <!--client logo start-->

    <section class="d-none">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ht-clients d-flex flex-wrap align-items-center text-center">
                        <div class="clients-logo">
                            <img class="img-fluid" src="/images/client/07.png" alt="">
                        </div>
                        <div class="clients-logo">
                            <img class="img-fluid" src="/images/client/08.png" alt="">
                        </div>
                        <div class="clients-logo">
                            <img class="img-fluid" src="/images/client/09.png" alt="">
                        </div>
                        <div class="clients-logo">
                            <img class="img-fluid" src="/images/client/10.png" alt="">
                        </div>
                        <div class="clients-logo">
                            <img class="img-fluid" src="/images/client/11.png" alt="">
                        </div>
                        <div class="clients-logo">
                            <img class="img-fluid" src="/images/client/12.png" alt="">
                        </div>
                        <div class="clients-logo">
                            <img class="img-fluid" src="/images/client/12.png" alt="">
                        </div>
                        <div class="clients-logo">
                            <img class="img-fluid" src="/images/client/12.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--client logo end-->


    <!--video start-->

    <section class="d-none">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12">
                    <div class="round-animation">
                        <div class="video-box">
                            <img class="img-fluid" src="/images/about/08.png" alt="">
                            <div class="video-btn video-btn-pos"><a
                                        class="play-btn popup-youtube d-flex align-items-center"
                                        href="https://www.youtube.com/watch?v=P_wKDMcr1Tg"><span class="btn btn-white">Play Now</span><img
                                            class="img-fluid pulse radius-4" src="/images/play.png" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mt-5 mt-lg-0">
                    <div class="section-title mb-3">
                        <h6>What We Do</h6>
                        <h2>We Provide best Digital Marketing Solution.</h2>
                    </div>
                    <p class="text-black">Deos et accusamus et iusto odio dignissimos qui blanditiis praesentium
                        voluptatum
                        dele corrupti quos dolores et quas molestias a orci facilisis rutrum.</p>
                    <ul class="custom-li list-unstyled list-icon-2 my-3 d-inline-block">
                        <li>Design must be functional</li>
                        <li>Futionality must into</li>
                        <li>Aenean pellentes vitae</li>
                        <li>Mattis effic iturut magna</li>
                        <li>Lusce enim nulla mollis</li>
                        <li>Phasellus eget felis</li>
                    </ul>
                    <a class="btn btn-theme" href="#"><span>Learn More</span></a>
                </div>
            </div>
        </div>
    </section>

    <!--video start-->


    <!--team start-->

    <section class="bg-contain d-none" data-bg-img="/images/pattern/02.png">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8 col-md-12">
                    <div class="section-title">
                        <h6>Creative Team</h6>
                        <h2 class="title">Meet Our Expert team member will ready for your service</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="team-member">
                        <div class="team-images">
                            <img class="img-fluid" src="/images/team/01.jpg" alt="">
                        </div>
                        <div class="team-description"><span>Manager</span>
                            <h5><a href="team-single.html">Jemy Lusto</a></h5>
                            <div class="team-social-icon">
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li><a href="#"><i class="fab fa-google-plus-g"></i></a>
                                    </li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 mt-5 mt-lg-0">
                    <div class="team-member active">
                        <div class="team-images">
                            <img class="img-fluid" src="/images/team/02.jpg" alt="">
                        </div>
                        <div class="team-description"><span>Manager</span>
                            <h5><a href="team-single.html">Jemy Lusto</a></h5>
                            <div class="team-social-icon">
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li><a href="#"><i class="fab fa-google-plus-g"></i></a>
                                    </li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 mt-5 mt-lg-0">
                    <div class="team-member">
                        <div class="team-images">
                            <img class="img-fluid" src="/images/team/03.jpg" alt="">
                        </div>
                        <div class="team-description"><span>Manager</span>
                            <h5><a href="team-single.html">Jemy Lusto</a></h5>
                            <div class="team-social-icon">
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li><a href="#"><i class="fab fa-google-plus-g"></i></a>
                                    </li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--team end-->


    <!--testimonial start-->
    <section class="d-none">
        <section class="bg-contain bg-pos-r pt-0" data-bg-img="/images/bg/02.png">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8 col-md-12">
                        <div class="section-title">
                            <h6>Testimonial</h6>
                            <h2 class="title">You Can See our clients feedback What You Say?</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="owl-carousel" data-items="1" data-autoplay="true">
                            <div class="item">
                                <div class="testimonial style-2">
                                    <div class="row align-items-center">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="testimonial-img info-img round-animation">
                                                <img class="img-fluid leftRight" src="/images/testimonial/01.png"
                                                     alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-12 ms-auto mt-5 mt-lg-0">
                                            <div class="testimonial-content">
                                                <div class="testimonial-quote"><i class="flaticon-quotation"></i>
                                                </div>
                                                <p>Professional recommended and great experience, Nam pulvinar vitae
                                                    neque et porttitor,
                                                    Praesent sed nisi eleifend, Consectetur adipisicing elit, sed do
                                                    eiusmodas temporo
                                                    incididunt</p>
                                                <div class="testimonial-caption">
                                                    <h5>Lana Roadse</h5>
                                                    <label>CEO of Loptus</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testimonial style-2">
                                    <div class="row align-items-center">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="testimonial-img info-img round-animation">
                                                <img class="img-fluid leftRight" src="/images/testimonial/01.png"
                                                     alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-12 ms-auto mt-5 mt-lg-0">
                                            <div class="testimonial-content">
                                                <div class="testimonial-quote"><i class="flaticon-quotation"></i>
                                                </div>
                                                <p>Professional recommended and great experience, Nam pulvinar vitae
                                                    neque et porttitor,
                                                    Praesent sed nisi eleifend, Consectetur adipisicing elit, sed do
                                                    eiusmodas temporo
                                                    incididunt</p>
                                                <div class="testimonial-caption">
                                                    <h5>Lana Roadse</h5>
                                                    <label>CEO of Loptus</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testimonial style-2">
                                    <div class="row align-items-center">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="testimonial-img info-img round-animation">
                                                <img class="img-fluid leftRight" src="/images/testimonial/01.png"
                                                     alt="">
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-12 ms-auto mt-5 mt-lg-0">
                                            <div class="testimonial-content">
                                                <div class="testimonial-quote"><i class="flaticon-quotation"></i>
                                                </div>
                                                <p>Professional recommended and great experience, Nam pulvinar vitae
                                                    neque et porttitor,
                                                    Praesent sed nisi eleifend, Consectetur adipisicing elit, sed do
                                                    eiusmodas temporo
                                                    incididunt</p>
                                                <div class="testimonial-caption">
                                                    <h5>Lana Roadse</h5>
                                                    <label>CEO of Loptus</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--testimonial end-->


        <!--price table start-->
        <!--price table style-1 start-->

        <section class="bg-contain bg-pos-r d-none" data-bg-img="/images/bg/02.png">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8 col-md-12">
                        <div class="section-title">
                            <h6>Price Table</h6>
                            <h2 class="title">Choose Your Pricing plan</h2>
                            <p class="mb-0">Deos et accusamus et iusto odio dignissimos qui blanditiis praesentium
                                voluptatum dele
                                corrupti quos dolores et quas molestias.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="tab text-center">
                            <!-- Nav tabs -->
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist"><a class="nav-link active"
                                                                                         id="nav-tab1"
                                                                                         data-bs-toggle="tab"
                                                                                         href="#tab1-1" role="tab"
                                                                                         aria-selected="true">Monthly</a>
                                    <a class="nav-link" id="nav-tab2" data-bs-toggle="tab" href="#tab1-2" role="tab"
                                       aria-selected="false">Yearly</a>
                                </div>
                            </nav>
                            <!-- Tab panes -->
                            <div class="tab-content px-0 pb-0" id="nav-tabContent">
                                <div role="tabpanel" class="tab-pane fade show active" id="tab1-1">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="price-table">
                                                <div class="round-p-animation"></div>
                                                <div class="price-header">
                                                    <h3 class="price-title">Starter</h3>
                                                </div>
                                                <img class="img-fluid my-4" src="/images/price/01.png" alt="">
                                                <div class="price-value">
                                                    <h2>$29<span>/Month</span></h2>
                                                </div>
                                                <div class="price-list">
                                                    <ul class="list-unstyled">
                                                        <li><i class="flaticon-tick"></i> 15 Analytics Compaign</li>
                                                        <li><i class="flaticon-tick"></i> Unlimited Site licenses</li>
                                                        <li><i class="flaticon-tick"></i> 1 Database</li>
                                                        <li><i class="flaticon-tick"></i> 10 Free Optimization</li>
                                                        <li><i class="flaticon-tick"></i> Html5 + Css3</li>
                                                        <li><i class="flaticon-tick"></i> 24/7 Customer Support</li>
                                                    </ul>
                                                </div>
                                                <a class="btn btn-theme mt-5" href="#"> <span>Get Started</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12 mt-5 mt-lg-0">
                                            <div class="price-table">
                                                <div class="round-p-animation"></div>
                                                <div class="price-header">
                                                    <h3 class="price-title">Premium</h3>
                                                </div>
                                                <img class="img-fluid my-4" src="/images/price/01.png" alt="">
                                                <div class="price-value">
                                                    <h2>$99<span>/Month</span></h2>
                                                </div>
                                                <div class="price-list">
                                                    <ul class="list-unstyled">
                                                        <li><i class="flaticon-tick"></i> 15 Analytics Compaign</li>
                                                        <li><i class="flaticon-tick"></i> Unlimited Site licenses</li>
                                                        <li><i class="flaticon-tick"></i> 1 Database</li>
                                                        <li><i class="flaticon-tick"></i> 10 Free Optimization</li>
                                                        <li><i class="flaticon-tick"></i> Html5 + Css3</li>
                                                        <li><i class="flaticon-tick"></i> 24/7 Customer Support</li>
                                                    </ul>
                                                </div>
                                                <a class="btn btn-theme mt-5" href="#"> <span>Get Started</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12 mt-5 mt-lg-0">
                                            <div class="price-table">
                                                <div class="round-p-animation"></div>
                                                <div class="price-header">
                                                    <h3 class="price-title">Professional</h3>
                                                </div>
                                                <img class="img-fluid my-4" src="/images/price/01.png" alt="">
                                                <div class="price-value">
                                                    <h2>$199<span>/Month</span></h2>
                                                </div>
                                                <div class="price-list">
                                                    <ul class="list-unstyled">
                                                        <li><i class="flaticon-tick"></i> 15 Analytics Compaign</li>
                                                        <li><i class="flaticon-tick"></i> Unlimited Site licenses</li>
                                                        <li><i class="flaticon-tick"></i> 1 Database</li>
                                                        <li><i class="flaticon-tick"></i> 10 Free Optimization</li>
                                                        <li><i class="flaticon-tick"></i> Html5 + Css3</li>
                                                        <li><i class="flaticon-tick"></i> 24/7 Customer Support</li>
                                                    </ul>
                                                </div>
                                                <a class="btn btn-theme mt-5" href="#"> <span>Get Started</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab1-2">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="price-table">
                                                <div class="round-p-animation"></div>
                                                <div class="price-header">
                                                    <h3 class="price-title">Starter</h3>
                                                </div>
                                                <img class="img-fluid my-4" src="/images/price/01.png" alt="">
                                                <div class="price-value">
                                                    <h2>$29<span>/Month</span></h2>
                                                </div>
                                                <div class="price-list">
                                                    <ul class="list-unstyled">
                                                        <li><i class="flaticon-tick"></i> 15 Analytics Compaign</li>
                                                        <li><i class="flaticon-tick"></i> Unlimited Site licenses</li>
                                                        <li><i class="flaticon-tick"></i> 1 Database</li>
                                                        <li><i class="flaticon-tick"></i> 10 Free Optimization</li>
                                                        <li><i class="flaticon-tick"></i> Html5 + Css3</li>
                                                        <li><i class="flaticon-tick"></i> 24/7 Customer Support</li>
                                                    </ul>
                                                </div>
                                                <a class="btn btn-theme mt-5" href="#"> <span>Get Started</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12 mt-5 mt-lg-0">
                                            <div class="price-table">
                                                <div class="round-p-animation"></div>
                                                <div class="price-header">
                                                    <h3 class="price-title">Premium</h3>
                                                </div>
                                                <img class="img-fluid my-4" src="/images/price/01.png" alt="">
                                                <div class="price-value">
                                                    <h2>$99<span>/Month</span></h2>
                                                </div>
                                                <div class="price-list">
                                                    <ul class="list-unstyled">
                                                        <li><i class="flaticon-tick"></i> 15 Analytics Compaign</li>
                                                        <li><i class="flaticon-tick"></i> Unlimited Site licenses</li>
                                                        <li><i class="flaticon-tick"></i> 1 Database</li>
                                                        <li><i class="flaticon-tick"></i> 10 Free Optimization</li>
                                                        <li><i class="flaticon-tick"></i> Html5 + Css3</li>
                                                        <li><i class="flaticon-tick"></i> 24/7 Customer Support</li>
                                                    </ul>
                                                </div>
                                                <a class="btn btn-theme mt-5" href="#"> <span>Get Started</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12 mt-5 mt-lg-0">
                                            <div class="price-table">
                                                <div class="round-p-animation"></div>
                                                <div class="price-header">
                                                    <h3 class="price-title">Professional</h3>
                                                </div>
                                                <img class="img-fluid my-4" src="/images/price/01.png" alt="">
                                                <div class="price-value">
                                                    <h2>$199<span>/Month</span></h2>
                                                </div>
                                                <div class="price-list">
                                                    <ul class="list-unstyled">
                                                        <li><i class="flaticon-tick"></i> 15 Analytics Compaign</li>
                                                        <li><i class="flaticon-tick"></i> Unlimited Site licenses</li>
                                                        <li><i class="flaticon-tick"></i> 1 Database</li>
                                                        <li><i class="flaticon-tick"></i> 10 Free Optimization</li>
                                                        <li><i class="flaticon-tick"></i> Html5 + Css3</li>
                                                        <li><i class="flaticon-tick"></i> 24/7 Customer Support</li>
                                                    </ul>
                                                </div>
                                                <a class="btn btn-theme mt-5" href="#"> <span>Get Started</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--price table style-1 end-->
    </section>

    <section>
        <div id="map" style="width: 100%; height: 500px"></div>
    </section>
</div>

<!--body content end-->