<?php

if (file_exists('TelegramErrorLogger.php')) {
    require_once 'TelegramErrorLogger.php';
}

class Telegram
{

    const INLINE_QUERY = 'inline_query';
    const CALLBACK_QUERY = 'callback_query';
    const BUSINESS_MESSAGE = 'business_message';
    const EDITED_MESSAGE = 'edited_message';
    const REPLY = 'reply';
    const MESSAGE = 'message';
    const PHOTO = 'photo';
    const VIDEO = 'video';
    const AUDIO = 'audio';
    const VOICE = 'voice';
    const ANIMATION = 'animation';
    const STICKER = 'sticker';
    const DOCUMENT = 'document';
    const LOCATION = 'location';
    const CONTACT = 'contact';
    const CHANNEL_POST = 'channel_post';
    const NEW_CHAT_MEMBER = 'new_chat_member';
    const LEFT_CHAT_MEMBER = 'left_chat_member';
    const MY_CHAT_MEMBER = 'my_chat_member';

    private $bot_token = '';
    private $data = [];
    private $updates = [];
    private $log_errors;
    private $proxy;
    private $update_type;

    public function __construct($bot_token, $log_errors = true, array $proxy = [])
    {
        $this->bot_token = $bot_token;
        $this->data = $this->getData();
        $this->log_errors = $log_errors;
        $this->proxy = $proxy;
    }

    public function endpoint($api, array $content, $post = true)
    {
        $url = 'https://api.telegram.org/bot' . $this->bot_token . '/' . $api;
        if ($post) {
            $reply = $this->sendAPIRequest($url, $content);
        } else {
            $reply = $this->sendAPIRequest($url, [], false);
        }

        return json_decode($reply, true);
    }

    public function getMe()
    {
        return $this->endpoint('getMe', [], false);
    }

    public function logOut()
    {
        return $this->endpoint('logOut', [], false);
    }

    public function close()
    {
        return $this->endpoint('close', [], false);
    }

    public function respondSuccess()
    {
        http_response_code(200);

        return json_encode(['status' => 'success']);
    }

    public function sendMessage(array $content)
    {
        return $this->endpoint('sendMessage', $content);
    }

    public function copyMessage(array $content)
    {
        return $this->endpoint('copyMessage', $content);
    }

    public function forwardMessage(array $content)
    {
        return $this->endpoint('forwardMessage', $content);
    }

    public function sendPhoto(array $content)
    {
        return $this->endpoint('sendPhoto', $content);
    }

    public function sendAudio(array $content)
    {
        return $this->endpoint('sendAudio', $content);
    }

    public function sendDocument(array $content)
    {
        return $this->endpoint('sendDocument', $content);
    }

    public function sendAnimation(array $content)
    {
        return $this->endpoint('sendAnimation', $content);
    }

    public function sendSticker(array $content)
    {
        return $this->endpoint('sendSticker', $content);
    }

    public function sendVideo(array $content)
    {
        return $this->endpoint('sendVideo', $content);
    }

    public function sendVoice(array $content)
    {
        return $this->endpoint('sendVoice', $content);
    }

    public function sendLocation(array $content)
    {
        return $this->endpoint('sendLocation', $content);
    }

    public function editMessageLiveLocation(array $content)
    {
        return $this->endpoint('editMessageLiveLocation', $content);
    }

    public function stopMessageLiveLocation(array $content)
    {
        return $this->endpoint('stopMessageLiveLocation', $content);
    }

    public function setChatStickerSet(array $content)
    {
        return $this->endpoint('setChatStickerSet', $content);
    }

    public function deleteChatStickerSet(array $content)
    {
        return $this->endpoint('deleteChatStickerSet', $content);
    }

    public function sendMediaGroup(array $content)
    {
        return $this->endpoint('sendMediaGroup', $content);
    }

    public function sendVenue(array $content)
    {
        return $this->endpoint('sendVenue', $content);
    }

    public function sendContact(array $content)
    {
        return $this->endpoint('sendContact', $content);
    }

    public function sendPoll(array $content)
    {
        return $this->endpoint('sendPoll', $content);
    }

    public function sendDice(array $content)
    {
        return $this->endpoint('sendDice', $content);
    }

    public function sendChatAction(array $content)
    {
        return $this->endpoint('sendChatAction', $content);
    }

    public function setMessageReaction(array $content)
    {
        return $this->endpoint('setMessageReaction', $content);
    }

    public function getUserProfilePhotos(array $content)
    {
        return $this->endpoint('getUserProfilePhotos', $content);
    }

    public function getFile($file_id)
    {
        $content = ['file_id' => $file_id];

        return $this->endpoint('getFile', $content);
    }

    public function kickChatMember(array $content)
    {
        return $this->endpoint('kickChatMember', $content);
    }

    public function leaveChat(array $content)
    {
        return $this->endpoint('leaveChat', $content);
    }

    public function banChatMember(array $content)
    {
        return $this->endpoint('banChatMember', $content);
    }

    public function unbanChatMember(array $content)
    {
        return $this->endpoint('unbanChatMember', $content);
    }

    public function getChat(array $content)
    {
        return $this->endpoint('getChat', $content);
    }

    public function getChatAdministrators(array $content)
    {
        return $this->endpoint('getChatAdministrators', $content);
    }

    public function getChatMemberCount(array $content)
    {
        return $this->endpoint('getChatMemberCount', $content);
    }

    public function getChatMembersCount(array $content)
    {
        return $this->getChatMemberCount($content);
    }

    public function getChatMember(array $content)
    {
        return $this->endpoint('getChatMember', $content);
    }

    public function answerInlineQuery(array $content)
    {
        return $this->endpoint('answerInlineQuery', $content);
    }

    public function setGameScore(array $content)
    {
        return $this->endpoint('setGameScore', $content);
    }

    public function getGameHighScores(array $content)
    {
        return $this->endpoint('getGameHighScores', $content);
    }

    public function answerCallbackQuery(array $content)
    {
        return $this->endpoint('answerCallbackQuery', $content);
    }

    public function setMyCommands(array $content)
    {
        return $this->endpoint('setMyCommands', $content);
    }

    public function deleteMyCommands(array $content)
    {
        return $this->endpoint('deleteMyCommands', $content);
    }

    public function getMyCommands(array $content)
    {
        return $this->endpoint('getMyCommands', $content);
    }

    public function setChatMenuButton(array $content)
    {
        return $this->endpoint('setChatMenuButton', $content);
    }

    public function getChatMenuButton(array $content)
    {
        return $this->endpoint('getChatMenuButton', $content);
    }

    public function setMyDefaultAdministratorRights(array $content)
    {
        return $this->endpoint('setMyDefaultAdministratorRights', $content);
    }

    public function getMyDefaultAdministratorRights(array $content)
    {
        return $this->endpoint('getMyDefaultAdministratorRights', $content);
    }

    public function editMessageText(array $content)
    {
        return $this->endpoint('editMessageText', $content);
    }

    public function editMessageCaption(array $content)
    {
        return $this->endpoint('editMessageCaption', $content);
    }

    public function editMessageMedia(array $content)
    {
        return $this->endpoint('editMessageMedia', $content);
    }

    public function editMessageReplyMarkup(array $content)
    {
        return $this->endpoint('editMessageReplyMarkup', $content);
    }

    public function stopPoll(array $content)
    {
        return $this->endpoint('stopPoll', $content);
    }

    public function downloadFile($telegram_file_path, $local_file_path)
    {
        $file_url = 'https://api.telegram.org/file/bot' . $this->bot_token . '/' . $telegram_file_path;
        $in = fopen($file_url, 'rb');
        $out = fopen($local_file_path, 'wb');

        while ($chunk = fread($in, 8192)) {
            fwrite($out, $chunk, 8192);
        }
        fclose($in);
        fclose($out);
    }

    public function setWebhook($url, $certificate = '')
    {
        if ($certificate == '') {
            $requestBody = ['url' => $url];
        } else {
            $requestBody = ['url' => $url, 'certificate' => "@$certificate"];
        }

        return $this->endpoint('setWebhook', $requestBody, true);
    }

    public function deleteWebhook()
    {
        return $this->endpoint('deleteWebhook', [], false);
    }

    public function getData()
    {
        if (empty($this->data)) {
            $rawData = file_get_contents('php://input');

            return json_decode($rawData, true);
        } else {
            return $this->data;
        }
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function Text()
    {
        $type = $this->getUpdateType();
        if ($type == self::CALLBACK_QUERY) {
            return @$this->data['callback_query']['data'];
        }
        if ($type == self::CHANNEL_POST) {
            return @$this->data['channel_post']['text'];
        }
        if ($type == self::EDITED_MESSAGE) {
            return @$this->data['edited_message']['text'];
        }

        return @$this->data['message']['text'];
    }

    public function Message()
    {
        $type = $this->getUpdateType();
        if ($type == self::CALLBACK_QUERY) {
            return @$this->data['callback_query']['message'];
        }
        if ($type == self::BUSINESS_MESSAGE) {
            return @$this->data['business_message'];
        }
        return @$this->data['message'];
    }

    public function Caption()
    {
        $type = $this->getUpdateType();
        if ($type == self::CHANNEL_POST) {
            return @$this->data['channel_post']['caption'];
        }

        return @$this->data['message']['caption'];
    }

    public function ChatID()
    {
        $chat = $this->Chat();

        return $chat['id'];
    }

    public function Chat()
    {
        $type = $this->getUpdateType();
        if ($type == self::CALLBACK_QUERY) {
            return @$this->data['callback_query']['message']['chat'];
        }
        if ($type == self::CHANNEL_POST) {
            return @$this->data['channel_post']['chat'];
        }
        if ($type == self::EDITED_MESSAGE) {
            return @$this->data['edited_message']['chat'];
        }
        if ($type == self::INLINE_QUERY) {
            return @$this->data['inline_query']['from'];
        }
        if ($type == self::MY_CHAT_MEMBER) {
            return @$this->data['my_chat_member']['chat'];
        }
        if ($type == self::BUSINESS_MESSAGE) {
            return @$this->data['business_message']['chat'];
        }

        return $this->data['message']['chat'];
    }

    public function MessageID()
    {
        $type = $this->getUpdateType();
        if ($type == self::CALLBACK_QUERY) {
            return @$this->data['callback_query']['message']['message_id'];
        }
        if ($type == self::BUSINESS_MESSAGE) {
            return @$this->data['business_message']['message_id'];
        }
        if ($type == self::CHANNEL_POST) {
            return @$this->data['channel_post']['message_id'];
        }
        if ($type == self::EDITED_MESSAGE) {
            return @$this->data['edited_message']['message_id'];
        }

        return $this->data['message']['message_id'];
    }

    public function ReplyToMessageID()
    {
        return $this->data['message']['reply_to_message']['message_id'];
    }

    public function ReplyToMessageFromUserID()
    {
        return $this->data['message']['reply_to_message']['forward_from']['id'];
    }

    public function Inline_Query()
    {
        return $this->data['inline_query'];
    }

    public function Callback_Query()
    {
        return $this->data['callback_query'];
    }

    public function Callback_ID()
    {
        return $this->data['callback_query']['id'];
    }

    public function Callback_Data()
    {
        return $this->data['callback_query']['data'];
    }

    public function Callback_Message()
    {
        return $this->data['callback_query']['message'];
    }

    public function Callback_ChatID()
    {
        return $this->data['callback_query']['message']['chat']['id'];
    }

    public function Callback_FromID()
    {
        return $this->data['callback_query']['from']['id'];
    }

    public function Date()
    {
        return $this->data['message']['date'];
    }

    public function FirstName()
    {
        $type = $this->getUpdateType();
        if ($type == self::CALLBACK_QUERY) {
            return @$this->data['callback_query']['from']['first_name'];
        }
        if ($type == self::BUSINESS_MESSAGE) {
            return @$this->data['business_message']['from']['first_name'];
        }
        if ($type == self::CHANNEL_POST) {
            return @$this->data['channel_post']['from']['first_name'];
        }
        if ($type == self::EDITED_MESSAGE) {
            return @$this->data['edited_message']['from']['first_name'];
        }

        return @$this->data['message']['from']['first_name'];
    }

    public function LastName()
    {
        $type = $this->getUpdateType();
        if ($type == self::CALLBACK_QUERY) {
            return @$this->data['callback_query']['from']['last_name'];
        }
        if ($type == self::CHANNEL_POST) {
            return @$this->data['channel_post']['from']['last_name'];
        }
        if ($type == self::EDITED_MESSAGE) {
            return @$this->data['edited_message']['from']['last_name'];
        }
        if ($type == self::MESSAGE) {
            return @$this->data['message']['from']['last_name'];
        }

        return '';
    }

    public function Username()
    {
        $type = $this->getUpdateType();
        if ($type == self::CALLBACK_QUERY) {
            return @$this->data['callback_query']['from']['username'];
        }
        if ($type == self::CHANNEL_POST) {
            return @$this->data['channel_post']['from']['username'];
        }
        if ($type == self::EDITED_MESSAGE) {
            return @$this->data['edited_message']['from']['username'];
        }

        return @$this->data['message']['from']['username'];
    }

    public function Location()
    {
        return $this->data['message']['location'];
    }

    public function UpdateID()
    {
        return $this->data['update_id'];
    }

    public function UpdateCount()
    {
        return count($this->updates['result']);
    }

    public function UserID()
    {
        $type = $this->getUpdateType();
        if ($type == self::CALLBACK_QUERY) {
            return $this->data['callback_query']['from']['id'];
        }
        if ($type == self::CHANNEL_POST) {
            return $this->data['channel_post']['from']['id'];
        }
        if ($type == self::EDITED_MESSAGE) {
            return @$this->data['edited_message']['from']['id'];
        }
        if ($type == self::INLINE_QUERY) {
            return @$this->data['inline_query']['from']['id'];
        }

        return $this->data['message']['from']['id'];
    }

    public function FromID()
    {
        return $this->data['message']['forward_from']['id'];
    }

    public function FromChatID()
    {
        return $this->data['message']['forward_from_chat']['id'];
    }

    public function messageFromGroup()
    {
        if ($this->data['message']['chat']['type'] == 'private') {
            return false;
        }

        return true;
    }

    public function getContactPhoneNumber()
    {
        if ($this->getUpdateType() == self::CONTACT) {
            return $this->data['message']['contact']['phone_number'];
        }

        return '';
    }

    public function messageFromGroupTitle()
    {
        if ($this->data['message']['chat']['type'] != 'private') {
            return $this->data['message']['chat']['title'];
        }

        return '';
    }

    public function buildKeyBoard(array $options, $onetime = false, $resize = false, $selective = true)
    {
        $replyMarkup = [
            'keyboard' => $options,
            'one_time_keyboard' => $onetime,
            'resize_keyboard' => $resize,
            'selective' => $selective,
        ];
        return json_encode($replyMarkup, true);
    }

    public function buildInlineKeyBoard(array $options)
    {
        $replyMarkup = [
            'inline_keyboard' => $options,
        ];
        return json_encode($replyMarkup, true);
    }

    public function buildInlineKeyboardButton(
        $text,
        $url = '',
        $callback_data = '',
        $switch_inline_query = null,
        $switch_inline_query_current_chat = null,
        $callback_game = '',
        $pay = ''
    )
    {
        $replyMarkup = [
            'text' => $text,
        ];
        if ($url != '') {
            $replyMarkup['url'] = $url;
        } elseif ($callback_data != '') {
            $replyMarkup['callback_data'] = $callback_data;
        } elseif (!is_null($switch_inline_query)) {
            $replyMarkup['switch_inline_query'] = $switch_inline_query;
        } elseif (!is_null($switch_inline_query_current_chat)) {
            $replyMarkup['switch_inline_query_current_chat'] = $switch_inline_query_current_chat;
        } elseif ($callback_game != '') {
            $replyMarkup['callback_game'] = $callback_game;
        } elseif ($pay != '') {
            $replyMarkup['pay'] = $pay;
        }

        return $replyMarkup;
    }

    public function buildKeyboardButton($text, $request_contact = false, $request_location = false)
    {
        return [
            'text' => $text,
            'request_contact' => $request_contact,
            'request_location' => $request_location,
        ];
    }

    public function buildKeyBoardHide($selective = true)
    {
        $replyMarkup = [
            'remove_keyboard' => true,
            'selective' => $selective,
        ];
        return json_encode($replyMarkup, true);
    }

    public function buildForceReply($selective = true)
    {
        $replyMarkup = [
            'force_reply' => true,
            'selective' => $selective,
        ];
        return json_encode($replyMarkup, true);
    }

    public function sendInvoice(array $content)
    {
        return $this->endpoint('sendInvoice', $content);
    }

    public function answerShippingQuery(array $content)
    {
        return $this->endpoint('answerShippingQuery', $content);
    }

    public function answerPreCheckoutQuery(array $content)
    {
        return $this->endpoint('answerPreCheckoutQuery', $content);
    }

    public function setPassportDataErrors(array $content)
    {
        return $this->endpoint('setPassportDataErrors', $content);
    }

    public function sendGame(array $content)
    {
        return $this->endpoint('sendGame', $content);
    }

    public function sendVideoNote(array $content)
    {
        return $this->endpoint('sendVideoNote', $content);
    }

    public function restrictChatMember(array $content)
    {
        return $this->endpoint('restrictChatMember', $content);
    }

    public function promoteChatMember(array $content)
    {
        return $this->endpoint('promoteChatMember', $content);
    }

    public function setChatAdministratorCustomTitle(array $content)
    {
        return $this->endpoint('setChatAdministratorCustomTitle', $content);
    }

    public function banChatSenderChat(array $content)
    {
        return $this->endpoint('banChatSenderChat', $content);
    }

    public function unbanChatSenderChat(array $content)
    {
        return $this->endpoint('unbanChatSenderChat', $content);
    }

    public function setChatPermissions(array $content)
    {
        return $this->endpoint('setChatPermissions', $content);
    }

    public function exportChatInviteLink(array $content)
    {
        return $this->endpoint('exportChatInviteLink', $content);
    }

    public function createChatInviteLink(array $content)
    {
        return $this->endpoint('createChatInviteLink', $content);
    }

    public function editChatInviteLink(array $content)
    {
        return $this->endpoint('editChatInviteLink', $content);
    }

    public function revokeChatInviteLink(array $content)
    {
        return $this->endpoint('revokeChatInviteLink', $content);
    }

    public function approveChatJoinRequest(array $content)
    {
        return $this->endpoint('approveChatJoinRequest', $content);
    }

    public function declineChatJoinRequest(array $content)
    {
        return $this->endpoint('declineChatJoinRequest', $content);
    }

    public function setChatPhoto(array $content)
    {
        return $this->endpoint('setChatPhoto', $content);
    }

    public function deleteChatPhoto(array $content)
    {
        return $this->endpoint('deleteChatPhoto', $content);
    }

    public function setChatTitle(array $content)
    {
        return $this->endpoint('setChatTitle', $content);
    }

    public function setChatDescription(array $content)
    {
        return $this->endpoint('setChatDescription', $content);
    }

    public function pinChatMessage(array $content)
    {
        return $this->endpoint('pinChatMessage', $content);
    }

    public function unpinChatMessage(array $content)
    {
        return $this->endpoint('unpinChatMessage', $content);
    }

    public function unpinAllChatMessages(array $content)
    {
        return $this->endpoint('unpinAllChatMessages', $content);
    }

    public function getStickerSet(array $content)
    {
        return $this->endpoint('getStickerSet', $content);
    }

    public function uploadStickerFile(array $content)
    {
        return $this->endpoint('uploadStickerFile', $content);
    }

    public function createNewStickerSet(array $content)
    {
        return $this->endpoint('createNewStickerSet', $content);
    }

    public function addStickerToSet(array $content)
    {
        return $this->endpoint('addStickerToSet', $content);
    }

    public function setStickerPositionInSet(array $content)
    {
        return $this->endpoint('setStickerPositionInSet', $content);
    }

    public function deleteStickerFromSet(array $content)
    {
        return $this->endpoint('deleteStickerFromSet', $content);
    }

    public function setStickerSetThumb(array $content)
    {
        return $this->endpoint('setStickerSetThumb', $content);
    }

    public function deleteMessage(array $content)
    {
        return $this->endpoint('deleteMessage', $content);
    }

    public function getUpdates($offset = 0, $limit = 100, $timeout = 0, $update = true)
    {
        $content = ['offset' => $offset, 'limit' => $limit, 'timeout' => $timeout];
        $this->updates = $this->endpoint('getUpdates', $content);
        if ($update) {
            if (array_key_exists('result', $this->updates) && is_array($this->updates['result']) && count($this->updates['result']) >= 1) { //for CLI working.
                $last_element_id = $this->updates['result'][count($this->updates['result']) - 1]['update_id'] + 1;
                $content = ['offset' => $last_element_id, 'limit' => '1', 'timeout' => $timeout];
                $this->endpoint('getUpdates', $content);
            }
        }

        return $this->updates;
    }

    public function serveUpdate($update)
    {
        $this->data = $this->updates['result'][$update];
    }

    public function getUpdateType()
    {
        if ($this->update_type) {
            return $this->update_type;
        }

        $update = $this->data;
        if (isset($update['inline_query'])) {
            $this->update_type = self::INLINE_QUERY;

            return $this->update_type;
        }
        if (isset($update['callback_query'])) {
            $this->update_type = self::CALLBACK_QUERY;

            return $this->update_type;
        }
        if (isset($update['business_message'])) {
            $this->update_type = self::BUSINESS_MESSAGE;

            return $this->update_type;
        }
        if (isset($update['edited_message'])) {
            $this->update_type = self::EDITED_MESSAGE;

            return $this->update_type;
        }
        if (isset($update['message']['text'])) {
            $this->update_type = self::MESSAGE;

            return $this->update_type;
        }
        if (isset($update['message']['photo'])) {
            $this->update_type = self::PHOTO;

            return $this->update_type;
        }
        if (isset($update['message']['video'])) {
            $this->update_type = self::VIDEO;

            return $this->update_type;
        }
        if (isset($update['message']['audio'])) {
            $this->update_type = self::AUDIO;

            return $this->update_type;
        }
        if (isset($update['message']['voice'])) {
            $this->update_type = self::VOICE;

            return $this->update_type;
        }
        if (isset($update['message']['contact'])) {
            $this->update_type = self::CONTACT;

            return $this->update_type;
        }
        if (isset($update['message']['location'])) {
            $this->update_type = self::LOCATION;

            return $this->update_type;
        }
        if (isset($update['message']['reply_to_message'])) {
            $this->update_type = self::REPLY;

            return $this->update_type;
        }
        if (isset($update['message']['animation'])) {
            $this->update_type = self::ANIMATION;

            return $this->update_type;
        }
        if (isset($update['message']['sticker'])) {
            $this->update_type = self::STICKER;

            return $this->update_type;
        }
        if (isset($update['message']['document'])) {
            $this->update_type = self::DOCUMENT;

            return $this->update_type;
        }
        if (isset($update['message']['new_chat_member'])) {
            $this->update_type = self::NEW_CHAT_MEMBER;

            return $this->update_type;
        }
        if (isset($update['message']['left_chat_member'])) {
            $this->update_type = self::LEFT_CHAT_MEMBER;

            return $this->update_type;
        }
        if (isset($update['my_chat_member'])) {
            $this->update_type = self::MY_CHAT_MEMBER;

            return $this->update_type;
        }
        if (isset($update['channel_post'])) {
            $this->update_type = self::CHANNEL_POST;

            return $this->update_type;
        }

        return false;
    }

    private function sendAPIRequest($url, array $content, $post = true)
    {
        if (isset($content['chat_id'])) {
            $url = $url . '?chat_id=' . $content['chat_id'];
            unset($content['chat_id']);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        }
        if (!empty($this->proxy)) {
            if (array_key_exists('type', $this->proxy)) {
                curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy['type']);
            }

            if (array_key_exists('auth', $this->proxy)) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy['auth']);
            }

            if (array_key_exists('url', $this->proxy)) {
                curl_setopt($ch, CURLOPT_PROXY, $this->proxy['url']);
            }

            if (array_key_exists('port', $this->proxy)) {
                curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy['port']);
            }
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        if ($result === false) {
            $result = json_encode(
                ['ok' => false, 'curl_error_code' => curl_errno($ch), 'curl_error' => curl_error($ch)]
            );
        }
        curl_close($ch);
        if ($this->log_errors) {
            if (class_exists('TelegramErrorLogger')) {
                $loggerArray = ($this->getData() == null) ? [$content] : [$this->getData(), $content];
                TelegramErrorLogger::log(json_decode($result, true), $loggerArray);
            }
        }

        return $result;
    }
}

// Helper for Uploading file using CURL
if (!function_exists('curl_file_create')) {
    function curl_file_create($filename, $mimetype = '', $postname = '')
    {
        return "@$filename;filename="
            . ($postname ?: basename($filename))
            . ($mimetype ? ";type=$mimetype" : '');
    }
}