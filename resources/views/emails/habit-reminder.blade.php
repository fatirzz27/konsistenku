<x-mail::message>
# ⏰ Hai {{ $habit->user->name }}!

Jangan lupa untuk **{{ $habit->name }}** hari ini!

@if($habit->streak && $habit->streak->current_streak > 0)
🔥 Streak kamu sekarang: **{{ $habit->streak->current_streak }} hari berturut-turut!**

Jangan sampai putus ya!
@else
Yuk mulai bangun streak-mu dari hari ini!
@endif

<x-mail::button :url="route('reminders.open', $habit)">
Check-in Sekarang
</x-mail::button>

Tetap semangat dan konsisten! 💪

Salam,<br>
{{ config('app.name') }}
</x-mail::message>