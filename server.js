let app = require('express')();
let http = require('http').createServer(app);
let io = require('socket.io')(http);
var users = [];
var messages = [];
var matches = [];
io.on('connection', socket => {
    socket.on('error', function (err) {
        console.log('errrorrrrr', err);
    });
    socket.on('user-connect', (userData) => {
        socket.userGuid = userData.userGuid;
        var userId = userData.userId;
        var userGuid = userData.userGuid;
        users.push({
            userId: userId,
            userGuid: userGuid,
            connected: true,
            status: 1,
            time: new Date().toLocaleString(),
        });
    })
    socket.on('retrieve-conversations-room', (senderGuid) => {
        const findMatches = matches.filter(o => o.receiverGuid === senderGuid);
        io.emit('retrieve-conversations-' + senderGuid, findMatches)
    })
    socket.on('get-conversation-room', (guidS) => {
        const SearchMessages = [...messages].filter((o) => (o.senderGuid === guidS.senderGuid && o.receiverGuid === guidS.receiverGuid) || (o.receiverGuid === guidS.senderGuid && o.senderGuid === guidS.receiverGuid));
        io.emit('get-conversation-' + guidS.receiverGuid, SearchMessages);
    })
    socket.on('new-private-message-room', (data) => {
        send_message(data).then(() => {
            notification_count_handler({ senderGuid: data.senderGuid, receiverGuid: data.receiverGuid, text: data.text });
        });
    });
    socket.on('text-message-delivered-room', (data) => {
        const messageIndex = messages.findIndex(o => o.messageGuid === data.messageGuid);
        const message = {
            ...messages[messageIndex]
        };
        message.delivered = true;
        messages[messageIndex] = message;
        io.emit('text-message-delivered-' + data.senderGuid, message)
    });
    socket.on('text-message-read-room', (data) => {
        const messageIndex = messages.findIndex(o => o.messageGuid === data.messageGuid);
        const message = {
            ...messages[messageIndex]
        };
        message.readTime = data.readTime;
        message.readStatus = true;
        message.delivered = true;
        messages[messageIndex] = message;
        io.emit('text-message-read-' + data.senderGuid, message)
        notification_count_handler({ senderGuid: data.senderGuid, receiverGuid: data.receiverGuid, text: message.text });
    });
    socket.on('receiver-info-room', (data) => {
        const index = users.findIndex(o => o.userGuid === data.senderGuid);
        if (index !== -1) {
            io.emit('receiver-info-' + data.receiverGuid, users[index]);
        } else {
            io.emit('receiver-info-' + data.receiverGuid, null);
        }
    });
    socket.on('user-online-offline-room', (data) => {
        const index = users.findIndex(o => o.userGuid === data.senderGuid);
        if (index !== -1) {
            users[index].status = data.status;
            users[index].time = new Date().toLocaleString();
        }
        io.emit('user-online-offline-' + data.senderGuid, data);
    });
    socket.on('matching-room', (guidS) => {
        const test = {
            id: socket.id,
            user_pet_guid: guidS.user_pet_guid,
            opposite_user_pet_guid: guidS.opposite_user_pet_guid,
            user_match_guid: guidS.user_match_guid
        }
        io.emit('matching-' + guidS.user_pet_guid, test);
    });

    socket.on('user-reject-match-room', (m) => {
        const findMatchesIndex = matches.findIndex(o => o.receiverGuid === m.user_own_pet_guid && o.senderGuid === m.user_opposite_pet_guid);
        const findMatchesIndex2 = matches.findIndex(o => o.senderGuid === m.user_own_pet_guid && o.receiverGuid === m.user_opposite_pet_guid);
        if (findMatchesIndex !== -1) {
            matches.splice(findMatchesIndex, 1);
        }
        if (findMatchesIndex2 !== -1) {
            matches.splice(findMatchesIndex2, 1);
        }
        const findMessages = messages.filter(o => o.senderGuid === m.user_own_pet_guid && o.receiverGuid === m.user_opposite_pet_guid);
        const findMessages2 = messages.filter(o => o.receiverGuid === m.user_own_pet_guid && o.senderGuid === m.user_opposite_pet_guid);
        if (findMessages.length > 0) {
            findMessages.forEach((message) => {
                const findIndex = messages.findIndex(o => o.messageGuid === message.messageGuid);
                if (findIndex !== -1) {
                    messages.splice(findIndex, 1);
                }
            })
        }
        if (findMessages2.length > 0) {
            findMessages2.forEach((message) => {
                const findIndex = messages.findIndex(o => o.messageGuid === message.messageGuid);
                if (findIndex !== -1) {
                    messages.splice(findIndex, 1);
                }
            })
        }
        io.emit('user-reject-match-' + m.user_own_pet_guid, m);
        io.emit('user-reject-match-' + m.user_opposite_pet_guid, m);
    })
    socket.on('typing', (data) => {
        io.emit('typing-' + data.receiverGuid + '-' + data.senderGuid)
    })
    socket.on('disconnect', () => {
        const index = users.findIndex(o => o.userId === socket.id);
        if (index !== -1) {
            users.splice(index, 1);
        }
    });
    socket.on('conversations-change', (guidS) => {
        const findMessages = messages.filter(o => o.senderGuid === guidS.senderGuid && o.receiverGuid === guidS.receiverGuid);
        const findMessages2 = messages.filter(o => o.receiverGuid === guidS.senderGuid && o.senderGuid === guidS.receiverGuid);
        if (findMessages.length > 0) {
            findMessages.forEach((message) => {
                const findIndex = messages.findIndex(o => o.messageGuid === message.messageGuid);
                if (findIndex !== -1) {
                    messages.splice(findIndex, 1);
                }
            })
        }
        if (findMessages2.length > 0) {
            findMessages2.forEach((message) => {
                const findIndex = messages.findIndex(o => o.messageGuid === message.messageGuid);
                if (findIndex !== -1) {
                    messages.splice(findIndex, 1);
                }
            })
        }
        guidS.messages.forEach((message) => {
            messages.push(message);
        });
        console.log(messages);
    })
    //Functions
    function send_message(data) {
        return new Promise(function (resolve, reject) {
            const message = {
                messageGuid: data.messageGuid,
                text: data.text,
                senderGuid: data.senderGuid,
                receiverGuid: data.receiverGuid,
                readStatus: false,
                media: data.media,
                sendTime: data.sendTime,
                readTime: data.readTime,
                delivered: false,
            }
            if (data.media) {
                message['gif_url'] = data.gif_url;
            }
            messages.push(message);
            io.emit('text-message-receive-' + data.receiverGuid, message);
            resolve(true);
        });
    }
    function notification_count_handler(data) {
        const findMatchesIndex = matches.findIndex(o => o.senderGuid === data.senderGuid && o.receiverGuid === data.receiverGuid);
        const findMessages = messages.filter(o => o.senderGuid === data.senderGuid && o.receiverGuid === data.receiverGuid);
        const unreadMessageCount = findMessages.filter(o => o.readStatus === false);
        if (findMatchesIndex == -1) {
            const match = {
                senderGuid: data.senderGuid,
                receiverGuid: data.receiverGuid,
                messageCount: findMessages.length,
                last_message: data.text,
                unreadMessageCount: unreadMessageCount.length
            }
            matches.push(match)
        } else {
            const match = {
                ...matches[findMatchesIndex]
            };
            match.messageCount = findMessages.length;
            match.unreadMessageCount = unreadMessageCount.length;
            match.last_message = findMessages[findMessages.length - 1].text;
            matches[findMatchesIndex] = match;
        }
        const findMatches = matches.filter(o => o.receiverGuid === data.receiverGuid);
        io.emit('retrieve-conversations-' + data.receiverGuid, findMatches)
    }
});
var port = 1414;
http.listen(port, () => {
    console.log('port:', port);
});
