@extends('front.layouts.app')

@section('title', 'Account - Islamia')

@section('content')
    <div class="container">
        <div id="my-account">
            <div class="my-account-box">
                <div class="my-account-identity">
                    <div class="my-account-photo">
                        <img src="{{ $user->avatar ?? '' }}" alt="{{ $user->name }}">
                    </div>
                    <div class="my-account-group">
                        <div class="my-account-name">{{ strtoupper($user->name) }}</div>
                        <div class="my-account-email">{{ $user->email }}</div>
                    </div>
                </div>
                <div class="my-account-arrow">
                    <img src="{{ asset('images/icons/svg/fi-rr-angle-right.svg') }}" alt="">
                </div>
            </div>

            <div class="my-account-category">
                Aktivitas kamu
            </div>

            <div class="my-account-box-menu">
                <div class="my-account-box-square">
                    <div class="my-account-box-menu-group">
                        <div class="my-account-group-flex">
                            <div class="my-account-icon">
                                <img src="{{ asset('images/icons/svg/fi-rr-bell.svg') }}" alt="">
                            </div>
                            <div class="my-account-menu">Notifikasi</div>
                            <div class="my-account-notify">
                                <div class="round"></div>
                            </div>
                        </div>
                        <div class="my-account-arrow-menu">
                            <img src="{{ asset('images/icons/svg/fi-rr-angle-right-dark.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="center-line"></div>
                    <div class="my-account-box-menu-group">
                        <div class="my-account-group-flex">
                            <div class="my-account-icon">
                                <img src="{{ asset('images/icons/svg/fi-rr-notebook.svg') }}" alt="">
                            </div>
                            <div class="my-account-menu">Riwayat Kelas</div>
                        </div>
                        <div class="my-account-arrow-menu">
                            <img src="{{ asset('images/icons/svg/fi-rr-angle-right-dark.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="center-line"></div>
                    <div class="my-account-box-menu-group">
                        <div class="my-account-group-flex">
                            <div class="my-account-icon">
                                <img src="{{ asset('images/icons/svg/fi-rr-hand-holding-heart.svg') }}" alt="">
                            </div>
                            <div class="my-account-menu">Donasi</div>
                        </div>
                        <div class="my-account-arrow-menu">
                            <img src="{{ asset('images/icons/svg/fi-rr-angle-right-dark.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="center-line"></div>
                    <div class="my-account-box-menu-group">
                        <div class="my-account-group-flex">
                            <div class="my-account-icon">
                                <img src="{{ asset('images/icons/svg/fi-rr-book.svg') }}" alt="">
                            </div>
                            <div class="my-account-menu">e-Book</div>
                            <div class="my-account-badge">(12)</div>
                        </div>
                        <div class="my-account-arrow-menu">
                            <img src="{{ asset('images/icons/svg/fi-rr-angle-right-dark.svg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-account-category">
                Hal lainnya
            </div>

            <div class="my-account-box-menu-2">
                <div class="my-account-box-square">
                    <div class="my-account-box-menu-group">
                        <div class="my-account-group-flex">
                            <div class="my-account-icon">
                                <img src="{{ asset('images/icons/svg/fi-rr-message.svg') }}" alt="">
                            </div>
                            <div class="my-account-menu">Kritik dan Saran</div>
                        </div>
                        <div class="my-account-arrow-menu">
                            <img src="{{ asset('images/icons/svg/fi-rr-angle-right-dark.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="center-line"></div>
                    <div class="my-account-box-menu-group">
                        <div class="my-account-group-flex">
                            <div class="my-account-icon">
                                <img src="{{ asset('images/icons/svg/fi-rr-briefcase.svg') }}" alt="">
                            </div>
                            <div class="my-account-menu">Ajakan Kerjasama</div>
                        </div>
                        <div class="my-account-arrow-menu">
                            <img src="{{ asset('images/icons/svg/fi-rr-angle-right-dark.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="center-line"></div>
                    <div class="my-account-box-menu-group">
                        <div class="my-account-group-flex">
                            <div class="my-account-icon">
                                <img src="{{ asset('images/icons/svg/fi-rr-info.svg') }}" alt="">
                            </div>
                            <div class="my-account-menu">Tentang Aplikasi</div>
                        </div>
                        <div class="my-account-arrow-menu">
                            <img src="{{ asset('images/icons/svg/fi-rr-angle-right-dark.svg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="social-media">
            <div class="flex">
                <img src="{{ asset('images/icons/svg/instagram.svg') }}" alt="">
                <img src="{{ asset('images/icons/svg/facebook.svg') }}" alt="">
                <img src="{{ asset('images/icons/svg/tiktok.svg') }}" alt="">
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>
    <br><br><br><br><br>

    <style>
        .container {
            padding: 0;
            margin: 0;
            background-color: #ffffff;
            min-height: 100vh;
        }

        #my-account {
            padding: 20px;
        }

        #my-account .my-account-box {
            width: 100%;
            height: 84px;
            background-color: #16B8A8;
            border-radius: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        #my-account .my-account-box .my-account-identity {
            display: flex;
            align-items: center;
            padding-left: 18px;
        }

        #my-account .my-account-box .my-account-arrow {
            display: flex;
            align-items: center;
            padding-right: 20px;
        }

        #my-account .my-account-box .my-account-identity .my-account-photo img {
            width: 52px;
            height: 52px;
            background-color: #ffffff;
            border-radius: 50%;
            object-fit: cover;
        }

        #my-account .my-account-box .my-account-identity .my-account-group {
            margin-left: 15px;
        }

        #my-account .my-account-box .my-account-identity .my-account-name {
            font-size: 16px;
            font-weight: 600;
            color: white;
            margin-bottom: 2px;
        }

        #my-account .my-account-box .my-account-identity .my-account-email {
            font-size: 14px;
            color: white;
            opacity: 0.9;
        }

        #my-account .my-account-category {
            font-size: 14px;
            color: #16B8A8;
            font-weight: 600;
            margin-bottom: 15px;
        }

        #my-account .my-account-box-menu,
        #my-account .my-account-box-menu-2 {
            width: 100%;
            background-color: white;
            border-radius: 14px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .my-account-box-square {
            padding: 15px;
        }

        .my-account-box-menu-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
        }

        .my-account-group-flex {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .my-account-icon {
            width: 24px;
            height: 24px;
            margin-right: 15px;
            display: flex;
            align-items: center;
        }

        .my-account-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .my-account-menu {
            font-size: 16px;
            color: #333333;
            font-weight: 500;
            flex: 1;
        }

        .my-account-notify .round {
            width: 8px;
            height: 8px;
            background-color: #FF4444;
            border-radius: 50%;
            margin-left: auto;
        }

        .my-account-badge {
            font-size: 14px;
            color: #666666;
            margin-left: 5px;
        }

        .my-account-arrow-menu {
            margin-left: 10px;
        }

        .center-line {
            width: 100%;
            height: 1px;
            background-color: #F0F0F0;
            margin: 0;
        }

        .social-media {
            padding: 0 20px;
            margin-bottom: 30px;
        }

        .social-media .flex {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .social-media img {
            width: 40px;
            height: 40px;
        }

        .logout-form {
            padding: 0 20px;
            margin-bottom: 40px;
        }

        .btn-logout {
            width: 100%;
            background-color: #E5E5E5;
            color: #333333;
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-logout:hover {
            background-color: #D5D5D5;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            #my-account {
                padding: 15px;
            }
            
            .social-media .flex {
                gap: 20px;
            }
        }
    </style>
@endsection