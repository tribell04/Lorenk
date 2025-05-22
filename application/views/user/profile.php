<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
        </div>

        <div class="card mb-3 col-lg-8">
            <div class="row no-gutters">
                <div class="col-md-4 d-flex align-items-center justify-content-center" style="background-color: #f8f9fa;">
                    <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" 
                         class="img-fluid rounded" 
                         alt="User Image" 
                         style="max-height: 200px; object-fit: contain;">
                </div>
                <div class="col-md-8 position-relative">
                    <div class="card-body">
                        <h5 class="card-title"><?= $user['name']; ?></h5>
                        <p class="card-text"><?= $user['email']; ?></p>
                        <p class="card-text">
                            <small class="text-muted">User since <?= date('d F Y', $user['date_created']); ?></small>
                        </p>
                    </div>

                    <a href="<?= base_url('user/editprofile'); ?>" 
                       class="btn btn-primary position-absolute" 
                       style="bottom: 1rem; right: 1rem;">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
