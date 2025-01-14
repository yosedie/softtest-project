@if($image = @file_get_contents('../public/images/user_img/'.$user_img))
    <img @error('photo') is-invalid @enderror
        src="{{ url('images/user_img/'.$user_img) }}" alt="profilephoto"
        class="img-responsive img-circle" data-toggle="modal"
        data-target="#exampleStandardModal{{ $id }}">
@else
<img @error('photo') is-invalid @enderror
        src="{{ Avatar::create($fname)->toBase64() }}" alt="profilephoto"
        class="img-responsive img-circle" data-toggle="modal"
        data-target="#exampleStandardModal{{ $id }}">

@endif
<div class="modal fade" id="exampleStandardModal2{{$id}}" tabindex="-1"
        role="dialog" aria-labelledby="exampleStandardModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleStandardModalLabel">
                        {{ $fname }}</h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="card m-b-30">
                            <div class="card-body py-5">
<div class="row">
<div class="user-modal">
@if($image =
@file_get_contents('../public/images/user_img/'.$user_img))
<img @error('photo') is-invalid @enderror
src="{{ url('images/user_img/'.$user_img) }}"
alt="profilephoto"
class="img-responsive img-circle">
@else
<img @error('photo') is-invalid @enderror
src="{{ Avatar::create($fname)->toBase64() }}"
alt="profilephoto"
class="img-responsive img-circle">
@endif
</div>
<div class="col-lg-12">
<h4 class="text-center">
{{ $fname }}{{ $lname }}
</h4>
<div class="button-list mt-4 mb-3">
<button type="button"
class="btn btn-primary-rgba"><i
class="feather icon-email mr-2"></i>{{ $email }}</button>
<button type="button"
class="btn btn-success-rgba"><i
class="feather icon-phone mr-2"></i>{{ $mobile }}</button>
</div>
<div class="table-responsive">
<table
class="table table-borderless mb-0 user-table">
<tbody>
@isset($dob)
<tr>
    <th scope="row" class="p-1">
        {{__('Date Of Birth :')}}</th>
    <td class="p-1">
        {{ $dob }}</td>
</tr>
@endisset
@isset($address)

<tr>
    <th scope="row" class="p-1">
        {{__('Address')}} :</th>
    <td class="p-1">
        {{ $address}}</td>
</tr>
@endisset
@isset($gender)

<tr>
    <th scope="row" class="p-1">
        {{__('Gender')}} :</th>
    <td class="p-1">
        {{ $gender}}</td>
</tr>
@endisset

<tr>
    <th scope="row" class="p-1">
        {{__('Role')}} :</th>
    <td class="p-1">
        {{ $role}}</td>
</tr>
@if($youtube_url != '' & $youtube_url != NULL)

<tr>
    <th scope="row" class="p-1">
        {{__('Youtube URL')}}</th>
    <td class="p-1">
        <a
            href="{{$youtube_url}}">{{str_limit($youtube_url, '30')}}</a>
    </td>
</tr>
@endif

@isset($fb_url)

<tr>
    <th scope="row" class="p-1">
       {{__(' Facebook URL')}}</th>
    <td class="p-1">
        <a
            href="{{$fb_url}}">{{str_limit($fb_url, '30')}}</a>
    </td>
</tr>
@endisset

@isset($twitter_url)

<tr>
    <th scope="row" class="p-1">
        {{__('Twitter URL')}}</th>
    <td class="p-1">
        <a
            href="{{$twitter_url}}">{{str_limit($twitter_url, '30')}}</a>
    </td>
</tr>
@endisset

@isset($linkedin_url)

<tr>
    <th scope="row" class="p-1">
       {{__(' Linkedin URL')}}</th>
    <td class="p-1">
        <a
            href="{{$linkedin_url}}">{{str_limit($linkedin_url, '30')}}</a>
    </td>
</tr>
@endisset

</tbody>
</table>
</div>
</div>
</div>
                            </div>