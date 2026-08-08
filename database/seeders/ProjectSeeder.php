<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

/**
 * Demo portfolio entries so the /portfolio pages have content to render.
 * Images are generated placeholders — replace slugs, copy and uploads with
 * real case studies from the admin panel.
 */
class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'slug' => 'demo-ecommerce',
                'client' => 'Demo Retail',
                'year' => 2025,
                'url' => null,
                'cover_image' => 'projects/placeholder-demo-ecommerce-1.png',
                'gallery' => [
                    'projects/placeholder-demo-ecommerce-1.png',
                    'projects/placeholder-demo-ecommerce-2.png',
                    'projects/placeholder-demo-ecommerce-3.png',
                    'projects/placeholder-demo-ecommerce-4.png',
                    'projects/placeholder-demo-ecommerce-5.png',
                ],
                'sort_order' => 10,
                'title' => [
                    'az' => 'E-ticarət Platforması',
                    'en' => 'E-commerce Platform',
                    'ru' => 'E-commerce платформа',
                    'de' => 'E-Commerce-Plattform',
                    'kk' => 'Электрондық сауда платформасы',
                    'uz' => 'Elektron tijorat platformasi',
                ],
                'summary' => [
                    'az' => 'Sifarişlərin yarısını itirən mağazanı ödənişə qədər gedən axına çevirdik.',
                    'en' => 'We turned a store that lost half its orders into a checkout flow that converts.',
                    'ru' => 'Магазин, терявший половину заказов, превратили в поток, доходящий до оплаты.',
                    'de' => 'Aus einem Shop, der die Hälfte seiner Bestellungen verlor, wurde ein Checkout, der konvertiert.',
                    'kk' => 'Тапсырыстарының жартысын жоғалтып отырған дүкенді төлемге жеткізетін ағынға айналдырдық.',
                    'uz' => 'Buyurtmalarining yarmini yoʻqotayotgan doʻkonni toʻlovga yetkazadigan oqimga aylantirdik.',
                ],
                'problem' => [
                    'az' => 'Müştəri məhsulu tapırdı, səbətə atırdı, amma ödəniş mərhələsində itirdi. Sifarişlər telefonla qəbul olunur, anbar Excel-də aparılırdı və eyni məhsul iki dəfə satılırdı. Sahibkar günün yarısını sifarişləri əl ilə uyğunlaşdırmağa sərf edirdi.',
                    'en' => 'Customers found products and filled the basket, then dropped at payment. Orders were taken by phone, stock lived in a spreadsheet, and the same item got sold twice. The owner spent half of every day reconciling orders by hand.',
                    'ru' => 'Клиент находил товар и наполнял корзину, но отваливался на оплате. Заказы принимали по телефону, склад вели в Excel, один и тот же товар продавался дважды. Владелец тратил полдня на ручную сверку заказов.',
                    'de' => 'Kunden fanden Produkte und füllten den Warenkorb, brachen aber bei der Zahlung ab. Bestellungen wurden telefonisch aufgenommen, der Bestand lag in einer Tabelle, und derselbe Artikel wurde zweimal verkauft. Der Inhaber verbrachte jeden Tag zur Hälfte damit, Bestellungen von Hand abzugleichen.',
                    'kk' => 'Клиент өнімді тауып, себетке салатын, бірақ төлем кезеңінде кетіп қалатын. Тапсырыстар телефонмен қабылданып, қойма Excel-де жүргізілетін және бір өнім екі рет сатылатын. Кәсіп иесі күнінің жартысын тапсырыстарды қолмен салыстыруға жұмсайтын.',
                    'uz' => 'Mijoz mahsulotni topib, savatga solardi, ammo toʻlov bosqichida ketib qolardi. Buyurtmalar telefon orqali qabul qilinardi, ombor Excel’da yuritilardi va bitta mahsulot ikki marta sotilardi. Tadbirkor kunining yarmini buyurtmalarni qoʻlda solishtirishga sarflardi.',
                ],
                'solution' => [
                    'az' => 'Əvvəlcə real müştərilərin alış yolunu izlədik və hansı addımda geri döndüklərini müəyyən etdik. Ödəniş prosesini üç səhifədən bir səhifəyə endirdik, onlayn ödəniş və çatdırılma xidmətlərini qoşduq. Anbar, sifariş və müştəri bazasını tək panelə köçürdük; səbəti yarımçıq qoyanlara avtomatik xatırlatma qurduq.',
                    'en' => 'We first watched how real customers moved through the purchase and where they turned back. Checkout went from three pages to one, with online payment and delivery integrated. Stock, orders and customers moved into a single panel, and abandoned baskets started triggering automatic reminders.',
                    'ru' => 'Сначала проследили путь реальных покупателей и нашли шаг, на котором они уходят. Оплату свели с трёх страниц к одной, подключили онлайн-платежи и доставку. Склад, заказы и клиентов перенесли в одну панель, а брошенные корзины стали получать автоматические напоминания.',
                    'de' => 'Zuerst haben wir beobachtet, wie echte Kunden durch den Kauf gehen und an welchem Schritt sie umkehren. Der Checkout ging von drei Seiten auf eine, Online-Zahlung und Lieferdienste wurden angebunden. Bestand, Bestellungen und Kunden zogen in ein einziges Panel, und abgebrochene Warenkörbe lösen seitdem automatische Erinnerungen aus.',
                    'kk' => 'Алдымен нақты клиенттердің сатып алу жолын бақылап, қай қадамда кері бұрылатынын анықтадық. Төлем процесін үш беттен бір бетке түсіріп, онлайн төлем мен жеткізу қызметтерін қостық. Қойма, тапсырыс және клиенттер базасын бір панельге көшірдік; себетті тастап кеткендерге автоматты еске салу орнаттық.',
                    'uz' => 'Avval haqiqiy mijozlarning xarid yoʻlini kuzatib, qaysi qadamda ortga qaytishini aniqladik. Toʻlov jarayonini uch sahifadan bitta sahifaga tushirdik, onlayn toʻlov va yetkazib berish xizmatlarini uladik. Ombor, buyurtma va mijozlar bazasini bitta panelga koʻchirdik; savatni tashlab ketganlarga avtomatik eslatma sozladik.',
                ],
                'result' => [
                    'az' => 'Ödənişə çatan sifarişlərin payı iki dəfədən çox artdı, sifarişin əl ilə emalına sərf olunan vaxt gündə 4 saatdan 30 dəqiqəyə düşdü. Yarımçıq səbət xatırlatmaları ilk aydan itirilmiş satışların bir hissəsini geri qaytardı.',
                    'en' => 'The share of orders reaching payment more than doubled, and manual order handling dropped from four hours a day to thirty minutes. Abandoned-basket reminders recovered part of the lost sales in the first month.',
                    'ru' => 'Доля заказов, доходящих до оплаты, выросла более чем вдвое, а ручная обработка сократилась с четырёх часов в день до тридцати минут. Напоминания о брошенной корзине вернули часть потерянных продаж уже в первый месяц.',
                    'de' => 'Der Anteil der Bestellungen, die bis zur Zahlung kommen, hat sich mehr als verdoppelt, und die manuelle Bearbeitung sank von vier Stunden pro Tag auf dreißig Minuten. Die Warenkorb-Erinnerungen holten schon im ersten Monat einen Teil der verlorenen Verkäufe zurück.',
                    'kk' => 'Төлемге жететін тапсырыстардың үлесі екі еседен астам өсті, ал тапсырысты қолмен өңдеуге кететін уақыт күніне 4 сағаттан 30 минутқа дейін қысқарды. Тастап кетілген себет еске салулары алғашқы айдан-ақ жоғалған сатылымның бір бөлігін қайтарды.',
                    'uz' => 'Toʻlovga yetib boradigan buyurtmalar ulushi ikki barobardan koʻproq oshdi, buyurtmani qoʻlda qayta ishlashga ketadigan vaqt esa kuniga 4 soatdan 30 daqiqaga tushdi. Tashlab ketilgan savat eslatmalari birinchi oydayoq yoʻqotilgan savdoning bir qismini qaytardi.',
                ],
            ],
            [
                'slug' => 'demo-corporate',
                'client' => 'Demo Group',
                'year' => 2025,
                'url' => null,
                'cover_image' => 'projects/placeholder-demo-corporate-1.png',
                'gallery' => [
                    'projects/placeholder-demo-corporate-1.png',
                    'projects/placeholder-demo-corporate-2.png',
                    'projects/placeholder-demo-corporate-3.png',
                    'projects/placeholder-demo-corporate-4.png',
                ],
                'sort_order' => 20,
                'title' => [
                    'az' => 'Korporativ Veb Sayt',
                    'en' => 'Corporate Website',
                    'ru' => 'Корпоративный сайт',
                    'de' => 'Unternehmenswebsite',
                    'kk' => 'Корпоративтік сайт',
                    'uz' => 'Korporativ sayt',
                ],
                'summary' => [
                    'az' => 'Köhnəlmiş saytı müştəri müraciəti gətirən satış alətinə çevirdik.',
                    'en' => 'We rebuilt a dated website into a sales tool that actually produces enquiries.',
                    'ru' => 'Устаревший сайт превратили в инструмент продаж, который приносит заявки.',
                    'de' => 'Aus einer veralteten Website wurde ein Vertriebswerkzeug, das tatsächlich Anfragen bringt.',
                    'kk' => 'Ескірген сайтты клиент өтінішін әкелетін сату құралына айналдырдық.',
                    'uz' => 'Eskirgan saytni mijoz murojaatini keltiradigan savdo vositasiga aylantirdik.',
                ],
                'problem' => [
                    'az' => 'Şirkətin sayti 6 il əvvəl hazırlanmışdı: telefonda düzgün açılmır, xidmətlər anlaşılmaz dildə təsvir olunurdu və əlaqə forması işləmirdi. Potensial müştərilər saytı açıb bir neçə saniyə sonra bağlayırdı, müraciətlər isə yalnız tanışlıq vasitəsilə gəlirdi.',
                    'en' => 'The site was six years old: it broke on phones, described services in language nobody understood, and the contact form did not work. Prospects opened it and left within seconds, so enquiries only ever came through personal contacts.',
                    'ru' => 'Сайту было шесть лет: он ломался на телефоне, услуги описывались непонятным языком, форма связи не работала. Потенциальные клиенты закрывали его через несколько секунд, а заявки приходили только через знакомых.',
                    'de' => 'Die Seite war sechs Jahre alt: Auf dem Handy brach sie zusammen, die Leistungen waren in einer Sprache beschrieben, die niemand verstand, und das Kontaktformular funktionierte nicht. Interessenten öffneten sie und waren nach Sekunden wieder weg — Anfragen kamen nur über persönliche Kontakte.',
                    'kk' => 'Компания сайты 6 жыл бұрын жасалған еді: телефонда дұрыс ашылмайтын, қызметтер түсініксіз тілде сипатталған және байланыс формасы жұмыс істемейтін. Әлеуетті клиенттер сайтты ашып, бірнеше секундтан кейін жабатын, ал өтініштер тек таныстық арқылы келетін.',
                    'uz' => 'Kompaniya sayti 6 yil oldin tayyorlangan edi: telefonda toʻgʻri ochilmasdi, xizmatlar tushunarsiz tilda tasvirlangan va aloqa formasi ishlamasdi. Potensial mijozlar saytni ochib, bir necha soniyadan keyin yopardi, murojaatlar esa faqat tanish-bilish orqali kelardi.',
                ],
                'solution' => [
                    'az' => 'Şirkətin müştəriləri ilə danışıb onların qərar verərkən verdiyi sualları topladıq və saytın strukturunu həmin suallara cavab kimi qurduq. Hər xidmət üçün ayrıca səhifə, real nümunələr və hər ekranda görünən müraciət düyməsi əlavə etdik. Məzmunu şirkətin özünün yeniləyə bilməsi üçün sadə idarəetmə paneli təhvil verdik.',
                    'en' => 'We talked to the company\'s customers, collected the questions they ask before deciding, and structured the site as the answer to them. Every service got its own page, real examples and a visible next step on each screen — plus a simple admin panel so the team updates content itself.',
                    'ru' => 'Поговорили с клиентами компании, собрали вопросы, которые они задают перед решением, и выстроили структуру сайта как ответ на них. У каждой услуги — своя страница, реальные примеры и заметный следующий шаг, плюс простая панель, чтобы команда сама обновляла контент.',
                    'de' => 'Wir haben mit den Kunden des Unternehmens gesprochen, die Fragen gesammelt, die sie vor der Entscheidung stellen, und die Seite als Antwort darauf strukturiert. Jede Leistung bekam eine eigene Seite, echte Beispiele und auf jedem Bildschirm einen sichtbaren nächsten Schritt — dazu ein einfaches Admin-Panel, mit dem das Team die Inhalte selbst pflegt.',
                    'kk' => 'Компанияның клиенттерімен сөйлесіп, олардың шешім қабылдар алдында қоятын сұрақтарын жинадық және сайт құрылымын сол сұрақтарға жауап ретінде құрдық. Әр қызметке жеке бет, нақты мысалдар және әр экранда көрінетін келесі қадам қостық. Мазмұнды компанияның өзі жаңарта алуы үшін қарапайым басқару панелін тапсырдық.',
                    'uz' => 'Kompaniyaning mijozlari bilan suhbatlashib, ular qaror qabul qilishdan oldin beradigan savollarni toʻpladik va sayt tuzilmasini oʻsha savollarga javob sifatida qurdik. Har bir xizmat uchun alohida sahifa, haqiqiy misollar va har bir ekranda koʻrinadigan keyingi qadam qoʻshdik. Mazmunni kompaniyaning oʻzi yangilay olishi uchun oddiy boshqaruv panelini topshirdik.',
                ],
                'result' => [
                    'az' => 'Sayt üzərindən gələn müraciətlər ilk üç ayda sıfırdan həftədə sabit rəqəmə çatdı. Satış komandası artıq zəngə "biz nə edirik" izahı ilə deyil, birbaşa təklifle başlayır — müştəri saytda oxuyub gəlir.',
                    'en' => 'Enquiries through the site went from zero to a steady weekly number within three months. The sales team no longer opens calls by explaining what the company does — the customer already read it on the site.',
                    'ru' => 'Заявки с сайта за три месяца выросли с нуля до стабильного недельного потока. Отдел продаж больше не начинает разговор с объяснения, чем занимается компания — клиент уже прочитал это на сайте.',
                    'de' => 'Anfragen über die Website stiegen in drei Monaten von null auf eine stabile Wochenzahl. Das Vertriebsteam beginnt Gespräche nicht mehr mit der Erklärung, was die Firma macht — der Kunde hat es bereits auf der Seite gelesen.',
                    'kk' => 'Сайт арқылы келетін өтініштер алғашқы үш айда нөлден тұрақты апталық санға жетті. Сату тобы енді қоңырауды «біз немен айналысамыз» деген түсіндірмеден бастамайды — клиент оны сайттан оқып келеді.',
                    'uz' => 'Sayt orqali keladigan murojaatlar dastlabki uch oyda noldan barqaror haftalik songa yetdi. Savdo jamoasi endi suhbatni «biz nima qilamiz» degan tushuntirishdan boshlamaydi — mijoz buni saytdan oʻqib keladi.',
                ],
            ],
            [
                'slug' => 'demo-mobile-app',
                'client' => 'Demo Service',
                'year' => 2024,
                'url' => null,
                'cover_image' => 'projects/placeholder-demo-mobile-app-1.png',
                'gallery' => [
                    'projects/placeholder-demo-mobile-app-1.png',
                    'projects/placeholder-demo-mobile-app-2.png',
                    'projects/placeholder-demo-mobile-app-3.png',
                    'projects/placeholder-demo-mobile-app-4.png',
                ],
                'sort_order' => 30,
                'title' => [
                    'az' => 'Mobil Tətbiq',
                    'en' => 'Mobile Application',
                    'ru' => 'Мобильное приложение',
                    'de' => 'Mobile Anwendung',
                    'kk' => 'Мобильді қосымша',
                    'uz' => 'Mobil ilova',
                ],
                'summary' => [
                    'az' => 'Sifarişi zəngdən tətbiqə keçirdik və müştərini geri qaytaran kanal qurduq.',
                    'en' => 'We moved ordering from phone calls into an app and built a channel that brings customers back.',
                    'ru' => 'Перенесли заказ из телефонных звонков в приложение и построили канал возврата клиентов.',
                    'de' => 'Wir haben die Bestellung vom Telefon in eine App verlegt und einen Kanal gebaut, der Kunden zurückholt.',
                    'kk' => 'Тапсырысты қоңыраудан қосымшаға көшіріп, клиентті қайтаратын арна құрдық.',
                    'uz' => 'Buyurtmani qoʻngʻiroqdan ilovaga koʻchirdik va mijozni qaytaradigan kanal qurdik.',
                ],
                'problem' => [
                    'az' => 'Bütün sifarişlər telefon zəngi ilə qəbul olunurdu: pik saatlarda xətt tutulur, müştəri gözləmirdi. Təkrar müştəri ilə əlaqə saxlamağın yolu yox idi — kampaniyadan yalnız sosial şəbəkəyə baxanlar xəbər tuturdu.',
                    'en' => 'Every order came in by phone: at peak hours the line was busy and customers simply gave up. There was no way to reach a returning customer either — only people who happened to check social media heard about a campaign.',
                    'ru' => 'Все заказы принимались по телефону: в час пик линия была занята, и клиент просто не дожидался. Связаться с вернувшимся клиентом было нечем — об акции узнавали только те, кто заглядывал в соцсети.',
                    'de' => 'Jede Bestellung kam per Telefon: In Stoßzeiten war die Leitung besetzt und Kunden gaben einfach auf. Wiederkehrende Kunden waren auch nicht erreichbar — von einer Aktion erfuhr nur, wer zufällig in die sozialen Netzwerke schaute.',
                    'kk' => 'Барлық тапсырыс телефон қоңырауы арқылы қабылданатын: ең қарбалас сағаттарда желі бос болмай, клиент күтпей кететін. Қайталама клиентпен байланысудың жолы жоқ еді — науқан туралы тек әлеуметтік желіні қарағандар білетін.',
                    'uz' => 'Barcha buyurtma telefon qoʻngʻirogʻi orqali qabul qilinardi: eng gavjum soatlarda liniya band boʻlib, mijoz kutib turmasdi. Takroriy mijoz bilan bogʻlanishning yoʻli ham yoʻq edi — kampaniya haqida faqat ijtimoiy tarmoqqa qaraganlar bilardi.',
                ],
                'solution' => [
                    'az' => 'İstifadəçinin tətbiqi nə üçün açacağını müəyyən edib bütün axını həmin ssenariyə uyğunlaşdırdıq: üç toxunuşda sifariş, saxlanmış ünvan və təkrar sifariş düyməsi. iOS və Android üçün tək layihə qurduq, push bildirişləri ilə kampaniya kanalı yaratdıq və mağazalara yerləşdirməni tam öz üzərimizə götürdük.',
                    'en' => 'We defined why someone would open the app at all and shaped the whole flow around it: an order in three taps, saved addresses and a one-tap reorder. One project served both iOS and Android, push notifications became the campaign channel, and store submission was handled end to end by us.',
                    'ru' => 'Определили, ради чего человек откроет приложение, и подстроили под это весь путь: заказ в три касания, сохранённые адреса и кнопка повторного заказа. Один проект для iOS и Android, push-уведомления как канал акций, публикация в сторах полностью на нас.',
                    'de' => 'Wir haben festgelegt, warum jemand die App überhaupt öffnet, und den gesamten Ablauf darauf ausgerichtet: Bestellung in drei Tipps, gespeicherte Adressen und eine Schaltfläche zum Nachbestellen. Ein Projekt bediente iOS und Android, Push-Benachrichtigungen wurden zum Kampagnenkanal, und die Veröffentlichung in den Stores haben wir vollständig übernommen.',
                    'kk' => 'Пайдаланушының қосымшаны не үшін ашатынын анықтап, бүкіл ағынды сол сценарийге бейімдедік: үш түртуде тапсырыс, сақталған мекенжай және қайта тапсырыс түймесі. iOS пен Android үшін бір жоба құрдық, push хабарландырулар арқылы науқан арнасын жасадық және дүкендерге жариялауды толық өз мойнымызға алдық.',
                    'uz' => 'Foydalanuvchi ilovani nima uchun ochishini aniqlab, butun oqimni oʻsha ssenariyga moslashtirdik: uch bosishda buyurtma, saqlangan manzil va qayta buyurtma tugmasi. iOS va Android uchun bitta loyiha qurdik, push bildirishnomalar orqali kampaniya kanalini yaratdik va doʻkonlarga joylashtirishni toʻliq oʻz zimmamizga oldik.',
                ],
                'result' => [
                    'az' => 'Sifarişlərin əsas hissəsi zəngdən tətbiqə keçdi, pik saatlarda itirilən müştəri problemi aradan qalxdı. Push bildirişi ilə göndərilən ilk kampaniya bir gündə əvvəlki həftəlik satışa yaxın nəticə verdi.',
                    'en' => 'Most orders moved from the phone line into the app, and peak-hour drop-off disappeared. The first campaign sent by push produced close to a previous full week of sales in a single day.',
                    'ru' => 'Большая часть заказов перешла из телефона в приложение, потери в час пик исчезли. Первая кампания через push дала за день результат, близкий к прежней недельной выручке.',
                    'de' => 'Der Großteil der Bestellungen wanderte von der Telefonleitung in die App, und der Verlust in Stoßzeiten verschwand. Die erste per Push versendete Kampagne brachte an einem Tag fast den Umsatz einer bisherigen ganzen Woche.',
                    'kk' => 'Тапсырыстардың негізгі бөлігі қоңыраудан қосымшаға көшті, қарбалас сағаттарда клиент жоғалту мәселесі жойылды. Push арқылы жіберілген алғашқы науқан бір күнде бұрынғы апталық сатылымға жуық нәтиже берді.',
                    'uz' => 'Buyurtmalarning asosiy qismi qoʻngʻiroqdan ilovaga oʻtdi, eng gavjum soatlarda mijoz yoʻqotish muammosi bartaraf boʻldi. Push orqali yuborilgan birinchi kampaniya bir kunda avvalgi haftalik savdoga yaqin natija berdi.',
                ],
            ],
        ];

        foreach ($projects as $data) {
            Project::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
