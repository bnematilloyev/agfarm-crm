<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    .container {
        max-width: 1440px;
        margin: 0 auto;
    }

    .workify__content {
        background: linear-gradient(180deg, #ffffff 4.44%, #006bff 50%);
    }

    .workify__wrapper {
        padding: 20px 10px 40px 10px;
    }

    .workify__about-title {
        font-size: 36px;
        font-weight: 700;
        line-height: 48px;
        text-align: center;
        margin-bottom: 15px;
    }

    .about-text-blue {
        color: #006bff;
    }

    .about-text-darkblu {
        color: #123169;
    }

    .workify__wrapper-img {
        width: 90%;
        margin: 0 auto;
        display: block;
    }

    .workify__about-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        padding: 20px;
    }

    .workify__about-cards {
        max-width: 693px;
        border-radius: 16px;
        background-color: #FFFFFF;
        box-shadow: 12px 12px 16px 8px #00000040;
        padding: 20px;
        margin-bottom: 60px;
        box-sizing: border-box;
    }

    .workify__about-cards p {
        font-size: 24px;
        font-weight: 800;
        line-height: 48px;
        text-align: left;
        color: #003366;
    }

    .workify__about-cards span {
        color: #003366;
        font-size: 18px;
        font-weight: 500;
        line-height: 32px;
        text-align: left;

    }

    .workify__about-box .about__images {
        width: 30%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .workify__about-box .about__images img {
        width: 100%;
    }

    .workify__face-id-cards {
        padding: 20px;

    }

    .workify__face-id-card {
        box-sizing: border-box;
        width: 100%;
        background: linear-gradient(276.7deg, #F5F5F5 1.37%, #AED5E6 23.74%, #7CC8E9 58.82%, rgba(55, 159, 182, 0.9) 96.46%);
        padding: 24px;
        border-radius: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        gap: 20px;
    }

    .workify__face-id-card .face-id-img {
        min-width: 400px;
        height: auto;
    }

    .workify__face-id-card .face-id-text {
        max-width: 60%;
    }

    .workify__face-id-card .face-id-text p {

        font-size: 36px;
        font-weight: 800;
        line-height: 48px;
        text-align: left;
        color: #F5F5F5;
    }

    .workify__face-id-card .face-id-text span {
        color: #F5F5F5;
        font-size: 20px;
        font-weight: 500;
        line-height: 32px;
        text-align: left;

    }

    .download__workify {
        border-radius: 80px;
        padding: 40px 150px;
        background-color: white;
        margin-bottom: 140px;
        margin-top: 80px;
        position: relative;
    }

    .download__workify .text__button {
        width: 45%;
        padding: 10px;
    }

    .download__workify h2 {
        font-size: 48px;
        font-weight: 700;
        line-height: 58.09px;
        text-align: left;
    }

    .download__workify .demo__version {
        text-decoration: none;
        padding: 16px;
        border-radius: 8px;
        background-color: #8A8A8A;
        color: white;
        font-size: 20px;
        font-weight: 600;
        line-height: 24px;
        text-align: left;
        display: inline-block;
        margin-right: 15px;
    }

    .download__workify .global__version {
        text-decoration: none;
        padding: 16px;
        border-radius: 8px;
        background: linear-gradient(88.46deg, rgba(18, 194, 233, 0.9) 0.71%, rgba(33, 135, 179, 0.9) 52.82%, rgba(48, 75, 124, 0.9) 96.28%);
        color: white;
        font-size: 20px;
        font-weight: 600;
        line-height: 24px;
        text-align: left;
    }

    .download-img {
        position: absolute;
        right: 100px;
        top: -40%;
        width: 100%;
        max-width: 400px;
    }


    @media only screen and (max-width: 756px) {
        .workify__about-title {
            font-size: 18px !important;
            text-align: start !important;
            line-height: 24px !important;
            margin-bottom: 10px;
        }

        .workify__wrapper-img {
            width: 100%;
        }

        .workify__about-box .about__images {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .workify__about-box .about__images img {
            width: 70%;
        }

        .workify__face-id-card {
            flex-wrap: wrap;
        }

        .face-id-text {
            max-width: 100% !important;
        }

        .workify__face-id-card .face-id-img {
            min-width: 100%;
        }

        .workify__face-id-card .face-id-text p {
            font-size: 24px;
        }

        .workify__face-id-card .face-id-text span {
            font-size: 16px;
            line-height: 24px;
        }

        .global__version, .demo__version {
            font-size: 12px !important;
            padding: 4px !important;
        }

        .download-img {
            position: static;
            right: 100px;
            top: -40%;
            width: 100%;
            max-width: 150px;
        }

        .download__workify {
            padding: 10px !important;
            border-radius: 8px !important;
            display: flex;
            justify-content: space-between;
        }

        .download-img .text__button {
            width: 50% !important;
            padding: 10px !important;
        }

        .download__workify h2 {
            font-size: 20px !important;
            line-height: 25px !important;
        }
    }
</style>
<div class="container">
    <div class="workify__content">
        <div class="workify__wrapper">
            <h1 class="workify__about-title">
            <span class="about-text-blue">Hodimlaringizni </span
            ><span class="about-text-darkblue">Workify</span>
                <span class="about-text-blue">bilan boshqaring!</span>
            </h1>
            <img src="/images/workify-img/home-img.svg" alt="" class="workify__wrapper-img"/>
        </div>
        <div class="workify__about-text">
            <div class="workify__about-box">
                <div class="">
                    <div class="workify__about-cards">
                        <p class="about__card-title">
                            Biz haqimida
                        </p>
                        <span class="about__card-text">
                            "Workify" mobil ilovasi, kompaniya yoki tashkilotlarning ishchi kadrlarini boshqarish va ularga qo'llab-quvvatlash uchun
                            yaratilgan sodda va samarali bir vosita. Bu ilova hodimlar uchun har xil funktsiyalarni o'z ichiga oladi, masalan, ishga qabul qilish, ish grafiklarini boshqarish, ma'lumotlar bazasiga kirish, murojaatlar va taqdimotlar yuborish, to'lovlarni boshqarish va boshqalar.
                </span>
                    </div>
                    <div class="workify__about-cards">
                        <p class="about__card-title">
                            Qulayliklar
                        </p>
                        <span class="about__card-text">
                            Hodimlarni boshqarish ilovasi sizga ishga qabul qilish jarayonlarini optimallashtirishda yordam beradi va
                            ish faoliyatini tizimlilashtirish uchun ilg'or qo'llanma va imkoniyatlar taqdim etadi. "Workify" — bu hodimlarni boshqarish uchun yangi mobil ilova, kompaniyalar uchun ish faoliyatini tizimlilashtirish va optimallashtirish uchun yaratilgan.             </span>
                    </div>
                </div>
                <div class="about__images">
                    <img src="/images/workify-img/phons.svg" alt="" class="iphone-img">

                </div>
            </div>
        </div>
        <div class="workify__face-id-cards">
            <div class="workify__face-id-card">
                <img src="/images/workify-img/faceid1.svg" alt="" class="face-id-img">
                <div class="face-id-text">
                    <p>Face ID</p>
                    <span>
                        "Workify" ilovasi, eng so'nggi texnologiyalardan foydalanib, foydalanuvchilarga maksimal xavfsizlik va qulaylik ta'minlash maqsadida Face ID (yuz tanish) tekshiruvi orqali kimligini tasdiqlash imkoniyatini taqdim etadi. Bu funksiya sayesida
                        hodimlar osonlik bilan ilovaga kirishni boshlay oladilar va shaxsiy ma'lumotlarga xavfsizlik bilan murojaat qila oladilar.
                    </span>
                </div>
            </div>
            <div class="workify__face-id-card">
                <div class="face-id-text">
                    <p>Face ID</p>
                    <span>
                        "Workify" ilovasi, eng so'nggi texnologiyalardan foydalanib, foydalanuvchilarga maksimal xavfsizlik va qulaylik ta'minlash maqsadida Face ID (yuz tanish) tekshiruvi orqali kimligini tasdiqlash imkoniyatini taqdim etadi. Bu funksiya sayesida
                        hodimlar osonlik bilan ilovaga kirishni boshlay oladilar va shaxsiy ma'lumotlarga xavfsizlik bilan murojaat qila oladilar.
                    </span>
                </div>
                <img src="/images/workify-img/faceid2.svg" alt="" class="face-id-img">
            </div>
        </div>
        <div style="padding: 20px">
            <div class="download__workify">
                <div class="text__button ">
                    <h2>Hodimlaringizni monitoring qilish uchun ilovani yuklab oling</h2>
                    <div class=" "
                         style=" display:flex; justify-content: space-between ; flex-wrap: wrap; gap: 30px ; margin-top: 30px   ;">
                        <a href="#" class="demo__version"> Demo versiya</a>
                        <a href="#" class="global__version"> Ilovani yuklab olish</a>
                    </div>
                </div>
                <img src="/images/workify-img/footer.svg" alt="" class="download-img">
            </div>
        </div>
    </div>
</div>
