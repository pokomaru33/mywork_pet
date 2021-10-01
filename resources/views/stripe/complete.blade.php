<x-app-layout>
   @if(auth()->user()->id == 1)

   <form action="{{route('stripe.charge')}}" method="POST">
    @csrf
     <script
         src="https://checkout.stripe.com/checkout.js" class="stripe-button"
         data-key="{{ env('STRIPE_KEY') }}"
         data-amount="1000"
         data-name="お支払い画面"
         data-label="payment"
         data-description="現在はデモ画面です"
         data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
         data-locale="auto"
         data-currency="JPY">
     </script>
    </form>

   @else
   <div>
    <p style="text-align: center; margin-top:30px">現在寄付はできません。</p>
</div>
    @endif
</x-app-layout>