@extends('layout.template')
@section('title', 'Dashboard')
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card deadline-card">
                                <div class="card-block p-4">
                                    <div class="countdown-wrap">
                                        <div class="countdown-info">
                                            <h5 class="text-white m-b-8 countdown-title">Countdown Penutupan Pendaftaran</h5>
                                            <div class="countdown-deadline-card">
                                                <span class="deadline-label">Deadline</span>
                                                <span class="deadline-date">{{ $pesertaDeadline->format('d M Y H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="countdown-grid">
                                            <div class="time-box">
                                                <div class="time-number" id="cd-days">0</div>
                                                <small>Hari</small>
                                            </div>
                                            <div class="time-box">
                                                <div class="time-number" id="cd-hours">0</div>
                                                <small>Jam</small>
                                            </div>
                                            <div class="time-box">
                                                <div class="time-number" id="cd-minutes">0</div>
                                                <small>Menit</small>
                                            </div>
                                            <div class="time-box">
                                                <div class="time-number" id="cd-seconds">0</div>
                                                <small>Detik</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="countdown-closed text-white mt-3 d-none" id="countdown-closed-msg">
                                        Pendaftaran sudah ditutup.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($categories as $index => $cat)
                        <div class="col-xl-3 col-md-6">
                            <!-- Menentukan warna berdasarkan index -->
                            <div class="card 
                                @if($index % 4 == 0) bg-c-yellow
                                @elseif($index % 4 == 1) bg-c-green
                                @elseif($index % 4 == 2) bg-c-pink
                                @else bg-c-lite-green
                                @endif
                                update-card">
                                <div class="card-block">
                                    <div class="row align-items-end">
                                        <div class="col-7">
                                            <h4 class="text-white">{{ $cat->total }}</h4>
                                            <h6 class="text-white m-b-0">{{ $cat->category->namacategory ?? 'Kategori Tidak Diketahui' }}</h6>
                                        </div>
                                        <div class="col-4 text-right">
                                            <canvas id="update-chart-{{ $loop->iteration }}" height="50"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="text-white m-b-0">
                                        <i class="feather icon-clock text-white f-14 m-r-10"></i>Update : {{ $cat->latest_created_at }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                                      
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<style>
    .deadline-card {
        background: linear-gradient(135deg, #1867c0, #24a0ed);
        border: 0;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, .15);
    }
    .countdown-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }
    .countdown-info {
        flex: 1 1 auto;
        min-width: 260px;
    }
    .countdown-title {
        font-size: 34px;
        font-weight: 600;
        line-height: 1.2;
        margin: 0;
        word-break: normal;
    }
    .countdown-deadline-card {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
        padding: 7px 12px;
        border-radius: 999px;
        background: #fff;
        border: 1px solid #f4c2c2;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        line-height: 1.2;
    }
    .deadline-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        color: #a11b1b;
        letter-spacing: 0.3px;
    }
    .deadline-date {
        font-size: 16px;
        font-weight: 600;
        color: #d12a2a;
    }
    .countdown-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(95px, 1fr));
        gap: 12px;
        min-width: 430px;
    }
    .deadline-card .time-box {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 10px;
        padding: 10px 4px;
        color: #fff;
        text-align: center;
    }
    .deadline-card .time-number {
        font-size: 40px;
        font-weight: 700;
        line-height: 1.1;
    }
    .countdown-closed {
        font-size: 16px;
        font-weight: 600;
    }
    @media (max-width: 991px) {
        .countdown-wrap {
            flex-direction: column;
            align-items: flex-start;
        }
        .countdown-grid {
            min-width: 100%;
            width: 100%;
            grid-template-columns: repeat(4, 1fr);
        }
        .countdown-title {
            font-size: 26px;
        }
        .countdown-deadline-card {
            width: 100%;
            justify-content: space-between;
        }
    }
</style>
<script>
    (function () {
        const targetTime = new Date("{{ $pesertaDeadline->format('Y-m-d H:i:s') }}").getTime();
        const closedMsg = document.getElementById('countdown-closed-msg');
        const daysEl = document.getElementById('cd-days');
        const hoursEl = document.getElementById('cd-hours');
        const minutesEl = document.getElementById('cd-minutes');
        const secondsEl = document.getElementById('cd-seconds');

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetTime - now;

            if (distance <= 0) {
                closedMsg.classList.remove('d-none');
                daysEl.textContent = '0';
                hoursEl.textContent = '0';
                minutesEl.textContent = '0';
                secondsEl.textContent = '0';
                return;
            }

            closedMsg.classList.add('d-none');
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            daysEl.textContent = days;
            hoursEl.textContent = hours.toString().padStart(2, '0');
            minutesEl.textContent = minutes.toString().padStart(2, '0');
            secondsEl.textContent = seconds.toString().padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
</script>
@endsection
