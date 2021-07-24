<div class="container shadow border rounded rounded-lg">
    <div class="row">
        <div class="col-12 p-5">
            <h2 class="text-center"> Student Login </h2>
            <form class="mt-4" action="students/submit" method="POST">
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" required
                        aria-describedby="emailHelp" placeholder="Email">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1" required
                        placeholder="Password">
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5" name="login">Submit</button>
                </div>
            </form>
            <div class="text-center text-muted mt-4">
                Don't know your credentials? Ask your college Administrator</a>
            </div>
        </div>
    </div>
</div>
