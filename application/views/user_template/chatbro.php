<?php
if (isset($user)) {

    // Configure here
    $admins = ['tungaqhd', 'admin1', 'admin2'];
    $secretKey = '';
    $encodedChatId = '';
    $siteDomain = 'demo.com'; // without https or http and www
    // END

    $siteUserFullName = $user['username'];
    $siteUserProfileUrl = site_url('admin/users/details/' . $user['id']);
    $permissions = [];
    $permissionsDisplay = '[]';
    // You can also change colors an images here
    if (!in_array($siteUserFullName, $admins)) {
        $permissions = [];
        $permissionsDisplay = "[]";
        $siteUserFullName .= '<vie level="' . $user['level'] . '"></vie>';
        $siteUserAvatarUrl = site_url('/assets/images/chat/user_chat.png');
        $siteUserFullNameColor = '#9f87ba';
        if ($user['level'] >= 20) {
            $siteUserFullNameColor = '#D65DB1';
        }
        if ($user['level'] >= 50) {
            $siteUserFullNameColor = '#FF6F91';
        }
        if ($user['level'] >= 100) {
            $siteUserFullNameColor = '#B05C00';
        }
        if ($user['level'] >= 200) {
            $siteUserFullNameColor = '#4E8397';
        }
        if ($user['level'] >= 500) {
            $siteUserFullNameColor = '#C34A36';
        }
    } else {
        $permissions = ['ban', 'delete'];
        $permissionsDisplay = "['ban', 'delete']";
        $siteUserFullName .= '<admin></admin>';
        $siteUserAvatarUrl = site_url('/assets/images/staff.png');
        $siteUserFullNameColor = '#957047';
    }
    $siteUserExternalId = $user['id'];


    if ($siteDomain != 'demo.com') {
?>
        <style>
            .chatbro_message_name {
                font-family: Poppins, sans-serif !important;
            }
        </style>
        <script id="chatBroEmbedCode">
            function ChatbroLoader(chats, async) {
                async = !1 !== async;
                var params = {
                        embedChatsParameters: chats instanceof Array ? chats : [chats],
                        lang: navigator.language || navigator.userLanguage,
                        needLoadCode: 'undefined' == typeof Chatbro,
                        embedParamsVersion: localStorage.embedParamsVersion,
                        chatbroScriptVersion: localStorage.chatbroScriptVersion
                    },
                    xhr = new XMLHttpRequest;
                xhr.withCredentials = !0;
                xhr.onload = function() {
                    eval(xhr.responseText);
                };
                xhr.onerror = function() {
                    console.error('Chatbro loading error')
                };
                xhr.open('GET', '//www.chatbro.com/embed.js?' +
                    btoa(unescape(encodeURIComponent(JSON.stringify(params)))), async);
                xhr.send();
            }
            /* Chatbro Widget Embed Code End */
            ChatbroLoader({
                encodedChatId: '<?= $encodedChatId ?>',
                siteDomain: '<?= $siteDomain ?>',
                siteUserExternalId: '<?= $siteUserExternalId ?>',
                siteUserFullName: '<?= $siteUserFullName ?>',
                siteUserAvatarUrl: '<?= $siteUserAvatarUrl ?>',
                siteUserProfileUrl: '<?= $siteUserProfileUrl ?>',
                siteUserFullNameColor: '<?= $siteUserFullNameColor ?>',
                permissions: <?= $permissionsDisplay ?>,
                signature: '<?= md5($siteDomain . '' . $siteUserExternalId . '' . $siteUserFullName . '' . $siteUserAvatarUrl . '' . $siteUserProfileUrl . '' . $siteUserFullNameColor . '' . implode('', $permissions) . '' . $secretKey) ?>'
            });
        </script>
<?php }
} ?>