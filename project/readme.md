# Street View Public API 
Д.Самдан - 16B1SEAS2873

## Танилцуулга
Street View Publish API нь 360 зурагуудыг Google Street View руу оруулах боломжийг ологдог.

Street View Publish API-ийг HTTP хүсэл гараж чадах багаж төхөөрөмжийг ашиглан хөгжүүлэж болно.

**Урьдчилсан нөхцөл**
1. Google API console орох боломжтой Google хаягтай байна.
2. Google Developers Console-д шинэ төсөл нээж API түлхүүр авах боломжтой болно.
3. Төсөл үүсгэхэд Street View Publish API үйлчилгээ сонгсон байх:
   a. Шинээх үүсэгсэн төсөл рүүгээ орнр
   b. Enabled APIs хуудас руу орж Street View Publish API идэвхтэй байгаа хэсгийг шалгана. Хэрэв үгүй байвал open the API Library руу орж идэхтэй болгно.
4. OAuth2.0 хэрэгжүүлэх талаар [мэдээлэл авах](https://developers.google.com/streetview/publish/authorizing)

**API түлхүүр авах**
Хэн нэвтэрж орсон тухай мэдээлэл шаардлагтай, үүнийг Google Developers Console оор дамжуулан авна.
1. Developers Console-ийн Credentials руу орно
2. API түлхүүр байгаа үед түүний хэрэглэж болно. Үгүй үед шинээр API түлхүүрийг New credentials ээр үүсгэн.

**Access token авах**
1.  [Google Developers](https://developers.google.com/oauthplayground/) OAuth 2.0 руу орох
2.  Баруун дээд буланд байгаа тохиргооны ийкон дээр дараад, доор нь байгаа Use your own OAuth credentials-ийг сонгож өөрийнхөө Client ID, Client secret оо хийнэ.
![How to insert](/doc/oauthplayground.png)
> Хэрэв бэлэн oAuth2.0 бйахгүй үед Developers Console орж Create credentials-ийг сонгон дараах тохиргооны дагуу oAuth2.0-ийг үүсгэн.

| Field                                       | Value                                                       |
| ------------------------------------------- | ----------------------------------------------------------- |
| Application type                            | Web application                                             |
| Name                                        | (any value)                                                 |
| Restrictions: Authorized JavaScript origins | (empty)                                                     |
| Restrictions: Authorized                    | redirect URIs	https://developers.google.com/oauthplayground |
3. Step 1Select & authorize APIs дээр очин Street View Public Api-ийг сонгон Authorize APIsийг дарна.
![alt](/doc/autorizeapis.png)
4. Exchange authorization code for tokens даран Access token гээ авна. Access token-ийн амьдрах хугцаан нь 60мин байдаг ба дууссан үед нь Refresh access token дахин авна.

## Зохион байгуулалт
/
&nbsp;&nbsp;&nbsp;&nbsp;`api`
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`function.js`
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`index.js`
&nbsp;&nbsp;&nbsp;&nbsp;`images/`
&nbsp;&nbsp;&nbsp;&nbsp;`.env`
&nbsp;&nbsp;&nbsp;&nbsp;`index.js`
&nbsp;&nbsp;&nbsp;&nbsp;`package.json`

`api/function.js` нь бүх `Street View Public Api`-ийн үндсэн кодуудыг агуулаж байна.
`api/index.js` нь `express route` юм. Get хүсэлтээр аван `functions.js` байгаа функуудын ашиглан зурагын мэдээлэл авах, нэмэх, шинэчлэх, устгах зэрэг үйлдэлүүд хийнэ.

`images/` нь Street View рүү оруулах зурагуудаа оруулна.

`.env` нь API KEY, ACCESS TOKEN зэрэг тохиргооны утгуудаа авна.

`index.js` үндсэн `express route` ба үндсэн `express`-ийн тохиргоо

`package.json` хэрэгтэй `npm`-ийн модуулуудын мэдээлэлийг агуулаж байна.

**Ашиглсан модууль**
| Нэр     | Үүрэг                                               |
| ------- | --------------------------------------------------- |
| dotenv  | `.env` файлийг хяалбар уншиж `process.env` руу өгнө |
| express | `node`-ийн HTTP server фрамворк                     |
| request | `http` хүсэлт илгээхэд ашиглна                      |

## Хэрэглээ
`/api/function.js` нь `svpa`(Street View Public API) гэсэн объектийг export хийсэн ба түүнийг ашиглахд:
```js
const svpa = require('./function');
```
гэж ашиглах файл дээрээ оруулаж өгнө.

`svpa` дотороо `getAllPhotos`, `getAPhoto`, `uploadAPhoto`, `updatePhotos`, `deleteAPhoto` зэрэг функцуудыг агуулсан байна.

**Дээр буй бүх функц** `callback` функцын авах ба түүнийгээ ашиглан юу resoponse дээр юу хийхээ шийднэ.
`callback` функц нь 3 аргумент авна
1. Алдаа                - error
2. Хариултийн объект    - request object 
3. Хариултийн эх бие    - response body

###**`svpa.getAllPhotos`**
Хэрэглэгчийн оруулсан зураагуудын мэдээлэлийг харна.
```js
getAllPhotos(callback);
```
Алдаагүй мэдээлэл ирсэн үед `response body`-д `JSON` байдалаар зурагуудын мэдээлэл буцаж ирнэ. ![get-photos](/doc/get-photos.png)

###**`svpa.getAPhoto`**
Хэрэглэгчийн оруулсан нэг зураагийн мэдээлэлийг харна.
```js
getAllPhotos(photoId, callback);
```
- `photoId`:`string`    - Зурагийн дугаар
Алдаагүй мэдээлэл ирсэн үед `response body`-д `JSON` байдалаар зурагийн мэдээлэл буцаж ирнэ. ![get-photos](/doc/get-photo.png)

###**`svpa.uploadAPhoto`**
Хэрэглэгчийн өгсөн мэдээлэлийн дагуу Street View руу зураг оруулна.
```js
uploadAPhoto(photoInfo = {}, callback);
```
- `photoInfo`:`object` - Оруулах зурагийн мэдээлэл
  - Үүнд заавал 
    - `photoPath`   - Зураг хаана байгаа мэдээлэл
    - `heading`     - Хаашаа хараж эхлэх
    - `latitude`    - өргөрөг мэдээлэл
    - `longitude`   - уртраг мэдээлэл
    - `captureTime` - Зураг авсан цаг, linux timestape байдалаар
  - Жишээ байдалаар доор үзүүлсэн:
```js
    {
        photoPath: path.join(__dirname, '../' + 'images/', 'school_1.jpg'),
        heading: 0,
        latitude: 47.922778,
        longitude: 106.921056,
        captureTime: 1545325560
    }
```
Алдаагүй мэдээлэл ирсэн үед `response body`-д `JSON` байдалаар зурагийн хаяг болон харуулах линк буцаж ирнэ. ![get-photos](/doc/upload-photo.png)

###**`svpa.updatePhotos`**
Street View-д байгаа зурагуудын мэдээлэлийг өөрчилнө
```js
updatePhotos(photosUpdateInfo = [], callback);
```
- `photosUpdateInfo`:`array of object` - Шинэчлэх зурагуудын мэдээлэл
```js
    [
        {
        "photo": {
            object(Photo)
        },
        "updateMask": string
        }
    ]
```
хэлбэртэй байна. [photo](https://developers.google.com/streetview/publish/reference/rest/v1/photo) дотор ямар зүйлсээ шинэчлэх мэдээлэл оруулна. [updateMask](https://developers.google.com/streetview/publish/reference/rest/v1/photo/update) юу шинэчилхээ зааж өгнө. [Дэлэгрэнгүй мэдээлэл.](https://developers.google.com/streetview/publish/reference/rest/v1/photos/batchUpdate)
#### Анхааруулга
Ямар нэгэн зурагийн мэдээлэл шинэчлэх үед `updateMask` өгөөгүй үед өмнө байсан зурагийн мэдээлэлийн шинээр ирж буй мэдээлэлээр дрна. Иймд `updateMask`-д одоо шинэчлэх зүйлийн хээ мэдээлэлээ өгнө. Жишээ:
```js
    [
        {
            "photo": {
                "photoId": {
                    "id": "FIRST_PHOTO_ID"
                },
                "pose": {
                    "latLngPair": {
                        "latitude": 37.1701638,
                        "longitude": -122.3624387
                    }
                }
            },
            "updateMask": "pose.latLngPair"
        },
        {
            "photo": {
                "photoId": {
                    "id": "SECOND_PHOTO_ID"
                },
                "pose": {
                    "latLngPair": {
                        "latitude": 37.1685704,
                        "longitude": -122.3618021
                    }
                }
            },
            "updateMask": "pose.latLngPair"
        }
    ]
```
Алдаагүй мэдээлэл ирсэн үед `response body`-д `JSON` байдалаар Шинэчлэгдсэн зурагуудын мэдээлэл буцаж ирнэ.   
![get-photos](/doc/update-photo.png)

###**`svpa.deleteAPhoto`**
Хэрэглэгчийн оруулсан зураагийг устгна.
```js
deleteAPhoto(photoId, callback);
```
- `photoId`:`string`    - Зурагийн дугаар
Алдаагүй мэдээлэл ирсэн үед `response body` хоосон байна.
![get-photos](/doc/delete-photo.png)