initSW();

function initSW() {
    if (!"serviceWorker" in navigator) {
        //service worker isn't supported
        return;
    }

    //don't use it here if you use service worker
    //for other stuff.
    if (!"PushManager" in window) {
        //push isn't supported
        return;
    }

    //register the service worker
    navigator.serviceWorker
        .register(`${__PATH__}/sw.js?v=2.0`)
        .then(() => {
            // console.log("serviceWorker installed!");
            initPush();
        })
        .catch((err) => {
            // console.log(err);
        });
}

function initPush() {
    if (!navigator.serviceWorker.ready) {
        return;
    }

    new Promise(function (resolve, reject) {
        const permissionResult = Notification.requestPermission(function (
            result
        ) {
            resolve(result);
        });

        if (permissionResult) {
            permissionResult.then(resolve, reject);
        }
    }).then((permissionResult) => {
        if (permissionResult !== "granted") {
            throw new Error("😔");
        }
        subscribeUser();
    });
}

function subscribeUser() {
    navigator.serviceWorker.ready
        .then((registration) => {
            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(
                    "BJs32WTk6UocdXOQ7a7RSBDMz68J3rYi3ZBzR-CwcLlCTRiu78h3ZyfPo9pIbEs1rLylgIOgb_z5RSnvqiOi6Ag"
                ),
            };

            return registration.pushManager.subscribe(subscribeOptions);
        })
        .then((pushSubscription) => {
            // console.log("PushSubscription: ", JSON.stringify(pushSubscription));
            storePushSubscription(pushSubscription);
        });
}

function urlBase64ToUint8Array(base64String) {
    var padding = "=".repeat((4 - (base64String.length % 4)) % 4);
    var base64 = (base64String + padding)
        .replace(/\-/g, "+")
        .replace(/_/g, "/");

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function storePushSubscription(pushSubscription) {
    const token = document
        .querySelector("meta[name=csrf-token]")
        .getAttribute("content");
    fetch(`${__PATH__}/push`, {
        method: "POST",
        body: JSON.stringify(pushSubscription),
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-Token": token,
        },
    })
        .then((res) => {
            return res.json();
        })
        .then((res) => {
            // console.log(res);
        })
        .catch((err) => {
            console.log(err);
        });
}
