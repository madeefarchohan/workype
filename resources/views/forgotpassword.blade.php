@section('header')
@include('header')
@show
<div class="login-content">
    <h3>Workype’s goal is to provide you and enterprise with the best business platform for new business opportunity and success.</h3>

    <form class="forget-form" action="http://localhost/workype/login" method="post" style="display: block !important;">
        <input type="hidden" name="_token" value="o9gecgHDXkkAAcjspxJjo67gXoaDY0GwO3E8DrZa">                    <h3 class="font-green">Forgot Password ?</h3>
        <p> Enter your e-mail address below to reset your password. </p>
        <div class="form-group">
            <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Email" name="email" value=""> </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
            <button type="submit" name="btn_reset_password" class="btn btn-success uppercase pull-right">Submit</button>
        </div>
    </form>
</div>

@section('footer')
@include('footer')
@show