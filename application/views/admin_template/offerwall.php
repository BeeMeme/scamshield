<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Offerwall settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/offerwalls') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Offerwall status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="offerwall_status">
                                <option value="on" <?= ($settings['offerwall_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['offerwall_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Offerwall min level</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="offerwall_min_level" name="offerwall_min_level" value="<?= $settings['offerwall_min_level'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Offerwall exp</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="offerwall_exp_reward" name="offerwall_exp_reward" value="<?= $settings['offerwall_exp_reward'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Offerwall min hold</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="offerwall_min_hold" name="offerwall_min_hold" value="<?= $settings['offerwall_min_hold'] ?>" step='0.00001'>
                            <small>Offerwalls with the reward lower than this will not be held</small>
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Monlix settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/offerwalls') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Monlix status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="monlix_status">
                                <option value="on" <?= ($settings['monlix_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['monlix_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="monlix_api" class="col-sm-3 col-form-label">Monlix API Key</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="monlix_api" name="monlix_api" value="<?= $settings['monlix_api'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="monlix_secret" class="col-sm-3 col-form-label">Monlix Secret Key</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="monlix_secret" name="monlix_secret" value="<?= $settings['monlix_secret'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="monlix_hold" class="col-sm-3 col-form-label">Monlix Hold</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="monlix_hold" name="monlix_hold" value="<?= $settings['monlix_hold'] ?>">
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Bitswall settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/offerwalls') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Bitswall status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="bitswall_status">
                                <option value="on" <?= ($settings['bitswall_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['bitswall_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="bitswall_api" class="col-sm-3 col-form-label">Bitswall API Key</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="bitswall_api" name="bitswall_api" value="<?= $settings['bitswall_api'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="bitswall_secret" class="col-sm-3 col-form-label">Bitswall Secret Key</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="bitswall_secret" name="bitswall_secret" value="<?= $settings['bitswall_secret'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="bitswall_hold" class="col-sm-3 col-form-label">Bitswall Hold</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="bitswall_hold" name="bitswall_hold" value="<?= $settings['bitswall_hold'] ?>">
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Wannads settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/offerwalls') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Wannads status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="wannads_status">
                                <option value="on" <?= ($settings['wannads_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['wannads_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="wannads_api_key" class="col-sm-3 col-form-label">Wannads API Key</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="wannads_api_key" name="wannads_api_key" value="<?= $settings['wannads_api_key'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="wannads_secret_key" class="col-sm-3 col-form-label">Wannads Secret Key</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="wannads_secret_key" name="wannads_secret_key" value="<?= $settings['wannads_secret_key'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="wannads_hold" class="col-sm-3 col-form-label">Wannads Hold</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="wannads_hold" name="wannads_hold" value="<?= $settings['wannads_hold'] ?>">
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">CPX Research settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/offerwalls') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">CPX Research status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="cpx_status">
                                <option value="on" <?= ($settings['cpx_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['cpx_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="cpx_app_id" class="col-sm-3 col-form-label">CPX App Id</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="cpx_app_id" name="cpx_app_id" value="<?= $settings['cpx_app_id'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="cpx_hash" class="col-sm-3 col-form-label">CPX Secure Hash</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="cpx_hash" name="cpx_hash" value="<?= $settings['cpx_hash'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="cpx_hold" class="col-sm-3 col-form-label">CPX Hold</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="cpx_hold" name="cpx_hold" value="<?= $settings['cpx_hold'] ?>">
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">OfferDady settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/offerwalls') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">OfferDaddy status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="offerdaddy_status">
                                <option value="on" <?= ($settings['offerdaddy_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['offerdaddy_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="offerdaddy_app_key" class="col-sm-3 col-form-label">OfferDady App Key</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="offerdaddy_app_key" name="offerdaddy_app_key" value="<?= $settings['offerdaddy_app_key'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="offerdaddy_app_token" class="col-sm-3 col-form-label">OfferDady App Token</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="offerdaddy_app_token" name="offerdaddy_app_token" value="<?= $settings['offerdaddy_app_token'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="offerdaddy_hold" class="col-sm-3 col-form-label">OfferDady Hold</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="offerdaddy_hold" name="offerdaddy_hold" value="<?= $settings['offerdaddy_hold'] ?>">
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">AyetStudios settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/offerwalls') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">AyetStudios status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="ayetstudios_status">
                                <option value="on" <?= ($settings['ayetstudios_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['ayetstudios_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="ayetstudios_api" class="col-sm-3 col-form-label">AyetStudios API</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="ayetstudios_api" name="ayetstudios_api" value="<?= $settings['ayetstudios_api'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="ayetstudios_id" class="col-sm-3 col-form-label">AyetStudios App Id</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="ayetstudios_id" name="ayetstudios_id" value="<?= $settings['ayetstudios_id'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="ayetstudios_hold" class="col-sm-3 col-form-label">AyetStudios Hold</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="ayetstudios_hold" name="ayetstudios_hold" value="<?= $settings['ayetstudios_hold'] ?>">
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Personaly settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/offerwalls') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">Personaly status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="personaly_status">
                                <option value="on" <?= ($settings['personaly_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['personaly_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="personaly_id" class="col-sm-3 col-form-label">Personaly Id</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="personaly_id" name="personaly_id" value="<?= $settings['personaly_id'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="personaly_hash" class="col-sm-3 col-form-label">Personaly Hash</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="personaly_hash" name="personaly_hash" value="<?= $settings['personaly_hash'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="personaly_secret_key" class="col-sm-3 col-form-label">Personaly Token</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="personaly_secret_key" name="personaly_secret_key" value="<?= $settings['personaly_secret_key'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="personaly_hold" class="col-sm-3 col-form-label">Personaly Hold</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="personaly_hold" name="personaly_hold" value="<?= $settings['personaly_hold'] ?>">
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">OfferToro settings</h4>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
                ?>
                <form action="<?= site_url('admin/update/offerwalls') ?>" method="POST">
                    <div class="form-group row mb-4">
                        <label class="col-sm-3 col-form-label">OfferToro status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="offertoro_status">
                                <option value="on" <?= ($settings['offertoro_status'] == 'on') ? 'selected' : '' ?>>On</option>
                                <option value="off" <?= ($settings['offertoro_status'] == 'off') ? 'selected' : '' ?>>Off</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="offertoro_pub_id" class="col-sm-3 col-form-label">OfferToro Pub Id</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="offertoro_pub_id" name="offertoro_pub_id" value="<?= $settings['offertoro_pub_id'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="offertoro_app_id" class="col-sm-3 col-form-label">OfferToro App Id</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="offertoro_app_id" name="offertoro_app_id" value="<?= $settings['offertoro_app_id'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="offertoro_app_secret" class="col-sm-3 col-form-label">OfferToro App Secret</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="offertoro_app_secret" name="offertoro_app_secret" value="<?= $settings['offertoro_app_secret'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="offertoro_hold" class="col-sm-3 col-form-label">OfferToro Hold</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="offertoro_hold" name="offertoro_hold" value="<?= $settings['offertoro_hold'] ?>">
                        </div>
                    </div>
                    <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-9">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>