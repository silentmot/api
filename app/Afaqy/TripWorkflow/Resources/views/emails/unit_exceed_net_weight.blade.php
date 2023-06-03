@component('mail::message')
# عزيزي {{ $user->first_name }} {{ $user->last_name }},

المركبة ({{ $trip->plate_number }}) تجاوزت الحد الاقصي للوزن الصافي, حيث كان وزن الخروج ({{ $trip->exit_weight }}) كيلو, بينما اقصي وزن صافي هو ({{ $trip->net_weight + ($trip->net_weight * 10 / 100) }}) كيلو.

اطيب التحيات,,,<br>
فريق عمل مردم جدة الذكي<br>
@endcomponent
