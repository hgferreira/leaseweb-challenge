<div class="flex justify-center">
  <form action="{{ route('dashboard.upload') }}" method="post" enctype="multipart/form-data">
  @csrf
    @if ($message = Session::get('success'))
      <div class="bg-green-100 rounded-lg py-5 px-6 mb-4 text-base text-green-700 mb-3" role="alert">
        The list was uploaded with success. Server list is updated.
      </div>  
    @endif
    @if (count($errors) > 0)
      <div class="bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-3" role="alert">
        Opss! Seem that something went wrong. See the errors bellow:
        <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
        </ul>
      </div>
    @endif
    <div class="mb-3 w-96">
      <label for="serverlist" class="form-label inline-block mb-2 text-gray-700">Upload server list CSV here:</label>
      <input class="form-control
      block
      w-full
      px-3
      py-1.5
      text-base
      font-normal
      text-gray-700
      bg-white bg-clip-padding
      border border-solid border-gray-300
      rounded
      transition
      ease-in-out
      m-0
      focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="serverlist" name="serverlist">
    </div>
    <div class="flex space-x-2 justify-center">
      <button type="submit" name="submit" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">Upload!</button>
    </div>  
  </form>
</div>