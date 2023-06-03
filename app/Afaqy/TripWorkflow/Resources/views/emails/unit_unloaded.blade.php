@component('mail::message')
# عزيزي {{ $user->first_name }} {{ $user->last_name }},

المركبة ({{ $trip->plate_number }}) لم تقم بتفريغ الحمولة في المردم.

اطيب التحيات,,,<br>
فريق عمل مردم جدة الذكي<br>
@endcomponent
