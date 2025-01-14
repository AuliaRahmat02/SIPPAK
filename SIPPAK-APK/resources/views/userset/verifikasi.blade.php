@extends('layout.Nonav')
@section('non')
    
    <div>
        <div class="bg-blue-2 mt-p flex items-center justify-center h-screen">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-4 text-center">Verifikasi OTP</h2>
                
                <p class="time text-center"></p> {{-- waktu hitung mundur --}}
                <p class="text-center mb-4">OTP Baru otomatis dikirim setelah hitungan mundur selesai</p>
                
                <p class="text-center mb-4">Masukan 6 digit kode OTP yang dikirim ke nomor handphone anda</p>
                <form action="/verified" method="POST" class="text-center" >
                    @csrf
                    <div class="flex justify-center mb-4">
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="nip" value="{{ $nip }}">
                            <input type="number" name="otp" class="text-center w-18 border-blue-400 border-2 focus:border-blue-400 focus:outline-none h-12 rounded-md p-3" placeholder="Masukkan OTP">
                    </div>
                    <input type="submit" value="verify" class="tombol">
                </form>
            </div>
        </div>
            
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#verificationForm').submit(function(e){
                e.preventDefault();
    
                var formData = $(this).serialize();
    
                $.ajax({
                    url:"{{ route('verifiedOtp') }}",
                    type:"POST",
                    data: formData,
                    success:function(res){
                        if(res.success){
                            alert(res.msg);
                            window.open("/","_self");
                        }
                        else{
                            $('#message_error').text(res.msg);
                            setTimeout(() => {
                                $('#message_error').text('');
                            }, 3000);
                        }
                    }
                });
    
            });
    
            $('#resendOtpVerification').click(function(){
                $(this).text('Wait...');
                var userMail = @json($email);
    
                $.ajax({
                    url:"{{ route('resendOtp') }}",
                    type:"GET",
                    data: {email:userMail },
                    success:function(res){
                        $('#resendOtpVerification').text('Resend Verification OTP');
                        if(res.success){
                            timer();
                            $('#message_success').text(res.msg);
                            setTimeout(() => {
                                $('#message_success').text('');
                            }, 3000);
                        }
                        else{
                            $('#message_error').text(res.msg);
                            setTimeout(() => {
                                $('#message_error').text('');
                            }, 3000);
                        }
                    }
                });
    
            });
        });
    
        function timer()
        {
            var seconds = 30;
            var minutes = 1;
    
            var timer = setInterval(() => {
    
                if(minutes < 0){
                    $('.time').text('');
                    clearInterval(timer);
                }
                else{
                    let tempMinutes = minutes.toString().length > 1? minutes:'0'+minutes;
                    let tempSeconds = seconds.toString().length > 1? seconds:'0'+seconds;
    
                    $('.time').text(tempMinutes+':'+tempSeconds);
                }
    
                if(seconds <= 0){
                    minutes--;
                    seconds = 59;
                }
    
                seconds--;
    
            }, 1000);
        }
    
        timer();
    
    </script>

@endsection
    

