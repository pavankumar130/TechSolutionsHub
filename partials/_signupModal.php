<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="signupModal">TechSolutionsHub- Signup to create an account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="/forum/partials/_handleSignup.php" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="signupEmail" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="signupEmail" name="signupEmail" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="signupPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="signupPassword" name="signupPassword">
                    </div>
                    <div class="mb-3">
                        <label for="signupcPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="signupcPassword" name="signupcPassword">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>