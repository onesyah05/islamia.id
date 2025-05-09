@extends('front.layouts.app')

<style>
        .button-container {
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        
        .teal-button {
            padding: 10px;
            background-color: #16B8A8;
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: 500;
            width: 100%;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .teal-button:hover {
            background-color: #18c194;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
</style>

@section('title', 'Detail')

@section('content')
    @include('front.components.header_detail')
    <div class="container">
        @include('front.components.float_btn')
        <div class="row">
            <div class="post-header">
                <h1 class="post-title">
                    Bagaimana hukum shalat ketika sedang dalam perjalanan?
                </h1>

                <div class="post-meta">
                    <span class="badge">Sholat</span>
                    <span class="meta-item">
                        <i class="fa fa-calendar-o"></i> Jum’at, 22 April 2025
                    </span>
                    <span class="meta-item">
                        <i class="fa fa-eye"></i> 2251x Dibaca
                    </span>
                </div>
            </div>
        </div>
        <div class="bar-space"></div>
        <div class="row" style="margin-left: 10px;margin-rigth:10px">
            <div class="col">
                <small>Penanya</small>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                    scrambled it to make a type specimen book?</p>
            </div>
        </div>
        <div class="row" style="margin-left: 10px;margin-right:10px">
            <div class="col">
                <small>Jawaban</small>
                <p>The question of whether a marriage can be valid without a guardian (wali) is one that has been discussed
                    extensively in Islamic jurisprudence. To provide a comprehensive answer, we must examine the various
                    scholarly opinions and their evidences from the Quran and Sunnah.

                    The majority of scholars, including those from the Shafi'i, Maliki, and Hanbali schools of thought, hold
                    that the presence of a guardian is a necessary condition for the validity of a marriage. They base this
                    on several evidences from the Quran and Sunnah.</p>
                <p style="text-align: right">وَأَنكِحُوا الْأَيَامَىٰ مِنكُمْ وَالصَّالِحِينَ مِنْ عِبَادِكُمْ وَإِمَائِكُمْ
                </p>
                <p>"And marry those among you who are single and the righteous among your male slaves and female slaves."
                    (Quran 24:32)</p>
                <p>The question of whether a marriage can be valid without a guardian (wali) is one that has been discussed
                    extensively in Islamic jurisprudence. To provide a comprehensive answer, we must examine the various
                    scholarly opinions and their evidences from the Quran and Sunnah.

                    The majority of scholars, including those from the Shafi'i, Maliki, and Hanbali schools of thought, hold
                    that the presence of a guardian is a necessary condition for the validity of a marriage. They base this
                    on several evidences from the Quran and Sunnah.</p>

            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="profile-card">
                    <div class="profile-image"></div>
                    <div class="profile-text">
                        <strong>Dr. Mushab Aljuhani</strong><br>
                        <span>Professor of Islamic Law at Al-Azhar University with over 20 years of experience in Islamic
                            jurisprudence. Specialized in family law and contemporary fiqh issues.</span>
                    </div>
                </div>

            </div>
        </div>

        <br>
        <div class="row">
            <div class="col">
                <div class="title-bar">
                    <p class="kiri"><b>Pertanyaan Terkai</b></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container-horizontal">
                @for ($i = 0; $i < 10; $i++)
                    <div class="card">
                        <div class="card-body">
                            <div class="title-bar-card">
                                <span class="kiri">Muamalah</span>
                                <a href="#" class="kanan">22 April 2025</i></a>
                            </div>
                            <div class="content-card">
                                <span class="title"><b>Bagaimana hukum shalat ketika sedang dalam
                                        perjalanan?</b></span><br>
                                <span class="des">Saya sering bepergian untuk urusan bisnis. Bagaimana ketentuan shalat
                                    jamak dan qashar...</span><br>
                                <a href="#" class="detail">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <div class="button-container">
                    <a href="#" class="teal-button">Ajukan Pertanyaan</a>
                </div>
            </div>
        </div>
        <br>
        <br>
    </div>

@endsection
