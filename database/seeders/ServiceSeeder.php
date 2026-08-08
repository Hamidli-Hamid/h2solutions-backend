<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * The public service catalogue — the same six services the homepage hero
 * advertises. Copy is written for buyers (outcomes, what you get, what it
 * costs you in time), not for engineers: no stack names, no framework talk.
 */
class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'slug' => 'web-development',
                'icon' => 'heroicon-o-computer-desktop',
                'sort_order' => 10,
                'title' => [
                    'az' => 'Veb saytlar',
                    'en' => 'Websites',
                    'ru' => 'Веб-сайты',
                    'de' => 'Websites',
                    'kk' => 'Веб-сайттар',
                    'uz' => 'Veb-saytlar',
                ],
                'summary' => [
                    'az' => 'Ziyarətçini müştəriyə çevirən, brendinizi güclü təqdim edən korporativ sayt.',
                    'en' => 'A corporate site that turns visitors into customers and presents your brand with authority.',
                    'ru' => 'Корпоративный сайт, который превращает посетителей в клиентов и достойно представляет бренд.',
                    'de' => 'Eine Unternehmenswebsite, die Besucher zu Kunden macht und Ihre Marke souverän präsentiert.',
                    'kk' => 'Келушіні клиентке айналдыратын, брендіңізді сенімді таныстыратын корпоративтік сайт.',
                    'uz' => 'Tashrif buyuruvchini mijozga aylantiradigan, brendingizni ishonchli taqdim etadigan korporativ sayt.',
                ],
                'description' => [
                    'az' => 'Saytınız 24/7 işləyən satış təmsilçinizdir. Biznesinizi və müştərinizin qərar verərkən verdiyi sualları araşdırırıq, sonra saytı məhz həmin suallara cavab verəcək şəkildə qururuq: aydın xidmət təqdimatı, inandırıcı nümunələr və hər addımda görünən müraciət düyməsi. Nəticə odur ki, ziyarətçi sizi rəqiblərlə müqayisə edərkən daha çox etibar edir və əlaqə saxlamağa daha meyilli olur.',
                    'en' => 'Your website is a sales rep that works 24/7. We study your business and the questions a buyer asks before deciding, then build the site to answer exactly those: a clear service story, convincing proof and a visible next step on every screen. Visitors comparing you against competitors trust you sooner and reach out more often.',
                    'ru' => 'Ваш сайт — это продавец, который работает 24/7. Мы изучаем бизнес и вопросы, которые клиент задаёт перед решением, и строим сайт как ответ именно на них: понятная подача услуг, убедительные доказательства и заметный следующий шаг на каждом экране. Посетитель, который сравнивает вас с конкурентами, быстрее доверяет и чаще пишет.',
                    'de' => 'Ihre Website ist ein Vertriebsmitarbeiter, der rund um die Uhr arbeitet. Wir untersuchen Ihr Geschäft und die Fragen, die ein Käufer vor der Entscheidung stellt, und bauen die Seite als Antwort genau darauf: eine klare Darstellung der Leistungen, überzeugende Belege und auf jedem Bildschirm ein sichtbarer nächster Schritt. Besucher, die Sie mit Wettbewerbern vergleichen, fassen schneller Vertrauen und melden sich häufiger.',
                    'kk' => 'Сайтыңыз — тәулік бойы жұмыс істейтін сату өкілі. Бизнесіңізді және сатып алушының шешім қабылдар алдында қоятын сұрақтарын зерттеп, сайтты дәл сол сұрақтарға жауап беретіндей құрамыз: қызметтердің анық баяндалуы, сенімді дәлелдер және әр экранда көрінетін келесі қадам. Сізді бәсекелестермен салыстырып отырған келуші тезірек сенеді және жиірек хабарласады.',
                    'uz' => 'Saytingiz — 24/7 ishlaydigan savdo vakili. Biznesingizni va xaridor qaror qabul qilishdan oldin beradigan savollarni oʻrganamiz, soʻng saytni aynan oʻsha savollarga javob beradigan qilib quramiz: xizmatlarning aniq taqdimoti, ishonarli dalillar va har bir ekranda koʻrinadigan keyingi qadam. Sizni raqobatchilar bilan solishtirayotgan tashrifchi tezroq ishonadi va koʻproq murojaat qiladi.',
                ],
                'features' => [
                    'az' => [
                        'Şablon deyil — brendinizə uyğun fərdi dizayn',
                        'Müraciət formaları və birbaşa zəng düymələri ilə müştəri axını',
                        'Məzmunu özünüz idarə edin: mətn və şəkilləri dəyişmək üçün sadə panel',
                        'Telefon, planşet və kompüterdə eyni səliqəli görünüş',
                        'Təhvildən sonra 1 ay pulsuz dəstək',
                    ],
                    'en' => [
                        'Custom design shaped around your brand — never a template',
                        'Enquiry forms and one-tap call buttons that generate leads',
                        'Update text and images yourself through a simple admin panel',
                        'Looks right on phone, tablet and desktop alike',
                        'One month of free support after handover',
                    ],
                    'ru' => [
                        'Индивидуальный дизайн под ваш бренд — не шаблон',
                        'Формы заявок и кнопки звонка, которые приносят обращения',
                        'Меняйте тексты и фото сами — через простую панель',
                        'Одинаково аккуратно на телефоне, планшете и компьютере',
                        'Месяц бесплатной поддержки после сдачи',
                    ],
                    'de' => [
                        'Individuelles Design nach Ihrer Marke — niemals eine Vorlage',
                        'Anfrageformulare und Anruf-Buttons, die Leads bringen',
                        'Texte und Bilder ändern Sie selbst über ein einfaches Admin-Panel',
                        'Sieht auf Smartphone, Tablet und Desktop gleichermaßen gut aus',
                        'Ein Monat kostenloser Support nach der Übergabe',
                    ],
                    'kk' => [
                        'Шаблон емес — брендіңізге сай жеке дизайн',
                        'Өтініш формалары мен қоңырау түймелері арқылы клиент ағыны',
                        'Мазмұнды өзіңіз басқарыңыз: мәтін мен суретті өзгертуге арналған қарапайым панель',
                        'Телефон, планшет және компьютерде бірдей ұқыпты көрініс',
                        'Тапсырғаннан кейін 1 ай тегін қолдау',
                    ],
                    'uz' => [
                        'Shablon emas — brendingizga mos individual dizayn',
                        'Ariza formalari va qoʻngʻiroq tugmalari orqali mijoz oqimi',
                        'Mazmunni oʻzingiz boshqaring: matn va rasmlarni oʻzgartirish uchun oddiy panel',
                        'Telefon, planshet va kompyuterda bir xil ozoda koʻrinish',
                        'Topshirilgandan keyin 1 oy bepul yordam',
                    ],
                ],
            ],
            [
                'slug' => 'mobile-apps',
                'icon' => 'heroicon-o-device-phone-mobile',
                'sort_order' => 20,
                'title' => [
                    'az' => 'Mobil tətbiqlər',
                    'en' => 'Mobile apps',
                    'ru' => 'Мобильные приложения',
                    'de' => 'Mobile Apps',
                    'kk' => 'Мобильді қосымшалар',
                    'uz' => 'Mobil ilovalar',
                ],
                'summary' => [
                    'az' => 'Müştərinizi cibində saxlayan, təkrar satışı artıran iOS və Android tətbiqi.',
                    'en' => 'An iOS and Android app that keeps you in your customer’s pocket and drives repeat sales.',
                    'ru' => 'Приложение для iOS и Android, которое держит вас в кармане клиента и увеличивает повторные продажи.',
                    'de' => 'Eine iOS- und Android-App, die Sie in der Hosentasche Ihres Kunden hält und Wiederkäufe bringt.',
                    'kk' => 'Клиентіңіздің қалтасында сақтайтын, қайталама сатылымды арттыратын iOS және Android қосымшасы.',
                    'uz' => 'Mijozingiz choʻntagida saqlaydigan, takroriy savdoni oshiradigan iOS va Android ilovasi.',
                ],
                'description' => [
                    'az' => 'Tətbiq müştəri ilə aranızdakı ən qısa yoldur: bildiriş göndərir, sadiqlik proqramını işlədir və sifarişi bir neçə toxunuşa endirir. Biz əvvəlcə istifadəçinin nəyə görə tətbiqi açacağını müəyyən edirik, sonra həmin ssenarini mümkün qədər sadələşdiririk. Beləliklə tətbiq telefonda silinmir, işlənir və satışa çevrilir.',
                    'en' => 'An app is the shortest path between you and your customer: it sends notifications, runs your loyalty programme and reduces an order to a few taps. We start by defining why someone would open it at all, then make that journey as short as possible — so the app stays installed, gets used and converts.',
                    'ru' => 'Приложение — самый короткий путь к клиенту: уведомления, программа лояльности и заказ в несколько касаний. Мы сначала определяем, ради чего человек его откроет, а затем максимально упрощаем этот сценарий — чтобы приложение не удаляли, а пользовались им и покупали.',
                    'de' => 'Eine App ist der kürzeste Weg zwischen Ihnen und Ihrem Kunden: Sie sendet Benachrichtigungen, betreibt Ihr Treueprogramm und reduziert eine Bestellung auf wenige Tipps. Wir legen zuerst fest, warum jemand sie überhaupt öffnen sollte, und machen diesen Weg so kurz wie möglich — damit die App installiert bleibt, genutzt wird und verkauft.',
                    'kk' => 'Қосымша — сіз бен клиенттің арасындағы ең қысқа жол: хабарландыру жібереді, адалдық бағдарламасын жүргізеді және тапсырысты бірнеше түртуге дейін қысқартады. Алдымен адам оны не үшін ашатынын анықтаймыз, содан кейін сол жолды барынша қысқартамыз — сонда қосымша өшірілмейді, қолданылады және сатылымға айналады.',
                    'uz' => 'Ilova — siz bilan mijoz oʻrtasidagi eng qisqa yoʻl: bildirishnoma yuboradi, sodiqlik dasturini yuritadi va buyurtmani bir necha bosishga qisqartiradi. Avval odam uni nima uchun ochishini aniqlaymiz, soʻng oʻsha yoʻlni imkon qadar qisqartiramiz — shunda ilova oʻchirilmaydi, ishlatiladi va savdoga aylanadi.',
                ],
                'features' => [
                    'az' => [
                        'iOS və Android üçün tək layihə — büdcəyə və vaxta qənaət',
                        'Push bildirişlərlə təkrar satış və kampaniya elanları',
                        'Yaşlı istifadəçinin belə çaşmadığı sadə axın',
                        'App Store və Google Play-ə yerləşdirmə tam bizim üzərimizdə',
                        'Hansı ekranın satdığını göstərən statistika',
                    ],
                    'en' => [
                        'One project for both iOS and Android — saves budget and time',
                        'Push notifications that bring repeat sales and campaign reach',
                        'A flow simple enough that no customer gets lost in it',
                        'App Store and Google Play submission handled entirely by us',
                        'Analytics that show which screen sells and which loses people',
                    ],
                    'ru' => [
                        'Один проект для iOS и Android — экономия бюджета и времени',
                        'Push-уведомления для повторных продаж и акций',
                        'Простой путь, в котором не теряется ни один клиент',
                        'Публикация в App Store и Google Play полностью на нас',
                        'Аналитика: какой экран продаёт, а какой теряет клиентов',
                    ],
                    'de' => [
                        'Ein Projekt für iOS und Android — spart Budget und Zeit',
                        'Push-Benachrichtigungen für Wiederkäufe und Kampagnen',
                        'Ein Ablauf, der so einfach ist, dass sich kein Kunde darin verliert',
                        'Veröffentlichung im App Store und bei Google Play übernehmen wir komplett',
                        'Analysen, die zeigen, welcher Screen verkauft und welcher Nutzer verliert',
                    ],
                    'kk' => [
                        'iOS және Android үшін бір жоба — бюджет пен уақытты үнемдейді',
                        'Push хабарландырулар арқылы қайталама сатылым және науқан хабарлары',
                        'Ешбір клиент адасып қалмайтындай қарапайым жол',
                        'App Store және Google Play-ге жариялауды толық өзіміз атқарамыз',
                        'Қай экран сататынын, қайсысы клиент жоғалтатынын көрсететін статистика',
                    ],
                    'uz' => [
                        'iOS va Android uchun bitta loyiha — byudjet va vaqtni tejaydi',
                        'Push bildirishnomalar orqali takroriy savdo va kampaniya xabarlari',
                        'Hech bir mijoz adashib qolmaydigan darajada oddiy yoʻl',
                        'App Store va Google Play’ga joylashtirishni toʻliq oʻz zimmamizga olamiz',
                        'Qaysi ekran sotayotganini, qaysi biri mijoz yoʻqotayotganini koʻrsatuvchi statistika',
                    ],
                ],
            ],
            [
                'slug' => 'e-commerce',
                'icon' => 'heroicon-o-shopping-bag',
                'sort_order' => 30,
                'title' => [
                    'az' => 'E-ticarət',
                    'en' => 'E-commerce',
                    'ru' => 'E-commerce',
                    'de' => 'E-Commerce',
                    'kk' => 'Электрондық коммерция',
                    'uz' => 'Elektron tijorat',
                ],
                'summary' => [
                    'az' => 'Səbətdən ödənişə qədər hər addımı satışa kökləyən onlayn mağaza.',
                    'en' => 'An online store tuned for sales at every step from basket to payment.',
                    'ru' => 'Интернет-магазин, настроенный на продажу на каждом шаге — от корзины до оплаты.',
                    'de' => 'Ein Onlineshop, der auf jedem Schritt vom Warenkorb bis zur Zahlung auf Verkauf ausgelegt ist.',
                    'kk' => 'Себеттен төлемге дейінгі әр қадамы сатылымға бейімделген онлайн дүкен.',
                    'uz' => 'Savatdan toʻlovgacha boʻlgan har bir qadami savdoga moslangan onlayn doʻkon.',
                ],
                'description' => [
                    'az' => 'Onlayn mağazada gəlir tək bir şeydən asılıdır: müştəri ödənişə qədər gedirmi? Biz məhz bu yolu qısaldırıq — məhsulu tapmaq, seçmək və ödəmək arasında hər artıq addımı silirik. Bundan başqa mağazanı gündəlik idarə edən komandanız üçün sifariş, anbar və kampaniyaların bir paneldən idarə olunmasını təmin edirik.',
                    'en' => 'In an online store revenue comes down to one thing: does the customer make it to payment? We shorten that path — every unnecessary step between finding a product, choosing it and paying is removed. And your team runs orders, stock and campaigns from a single panel instead of three spreadsheets.',
                    'ru' => 'В интернет-магазине выручка зависит от одного: доходит ли клиент до оплаты. Мы сокращаем этот путь — убираем каждый лишний шаг между «нашёл», «выбрал» и «оплатил». А ваша команда ведёт заказы, склад и акции из одной панели, а не из трёх таблиц.',
                    'de' => 'Im Onlineshop hängt der Umsatz an einer Frage: Kommt der Kunde bis zur Zahlung? Genau diesen Weg verkürzen wir — jeder überflüssige Schritt zwischen Produkt finden, auswählen und bezahlen fällt weg. Und Ihr Team führt Bestellungen, Lager und Kampagnen aus einer einzigen Oberfläche statt aus drei Tabellen.',
                    'kk' => 'Онлайн дүкенде табыс бір нәрсеге байланысты: клиент төлемге дейін жете ме? Дәл осы жолды қысқартамыз — өнімді табу, таңдау және төлеу арасындағы әрбір артық қадамды алып тастаймыз. Ал командаңыз тапсырыс, қойма және науқандарды үш кестенің орнына бір панельден жүргізеді.',
                    'uz' => 'Onlayn doʻkonda daromad bitta narsaga bogʻliq: mijoz toʻlovgacha yetib boradimi? Aynan shu yoʻlni qisqartiramiz — mahsulotni topish, tanlash va toʻlash oʻrtasidagi har bir ortiqcha qadamni olib tashlaymiz. Jamoangiz esa buyurtma, ombor va kampaniyalarni uchta jadval oʻrniga bitta paneldan yuritadi.',
                ],
                'features' => [
                    'az' => [
                        'Onlayn ödəniş və çatdırılma xidmətləri ilə inteqrasiya',
                        'Səbəti yarımçıq qoyanlara avtomatik xatırlatma',
                        'Sifariş, anbar və müştəri bazası tək paneldə',
                        'Endirim, promokod və kampaniya sistemi',
                        'Hansı məhsulun nə qədər qazandırdığını göstərən hesabatlar',
                    ],
                    'en' => [
                        'Integrated with online payment and delivery providers',
                        'Automatic reminders for customers who abandon the basket',
                        'Orders, stock and customer base in one panel',
                        'Discounts, promo codes and campaign tooling',
                        'Reports showing which product actually earns',
                    ],
                    'ru' => [
                        'Интеграция с онлайн-оплатой и службами доставки',
                        'Автоматические напоминания о брошенной корзине',
                        'Заказы, склад и база клиентов в одной панели',
                        'Скидки, промокоды и инструменты акций',
                        'Отчёты: какой товар действительно приносит прибыль',
                    ],
                    'de' => [
                        'Angebunden an Online-Zahlungsanbieter und Lieferdienste',
                        'Automatische Erinnerungen an Kunden, die den Warenkorb abbrechen',
                        'Bestellungen, Lager und Kundenstamm in einem Panel',
                        'Rabatte, Promo-Codes und Kampagnen-Werkzeuge',
                        'Berichte, die zeigen, welches Produkt wirklich verdient',
                    ],
                    'kk' => [
                        'Онлайн төлем және жеткізу қызметтерімен интеграция',
                        'Себетті тастап кеткендерге автоматты еске салу',
                        'Тапсырыс, қойма және клиенттер базасы бір панельде',
                        'Жеңілдік, промокод және науқан жүйесі',
                        'Қай өнім қанша пайда әкелетінін көрсететін есептер',
                    ],
                    'uz' => [
                        'Onlayn toʻlov va yetkazib berish xizmatlari bilan integratsiya',
                        'Savatni tashlab ketganlarga avtomatik eslatma',
                        'Buyurtma, ombor va mijozlar bazasi bitta panelda',
                        'Chegirma, promokod va kampaniya tizimi',
                        'Qaysi mahsulot qancha foyda keltirayotganini koʻrsatuvchi hisobotlar',
                    ],
                ],
            ],
            [
                'slug' => 'seo-optimization',
                'icon' => 'heroicon-o-magnifying-glass',
                'sort_order' => 40,
                'title' => [
                    'az' => 'SEO xidməti',
                    'en' => 'SEO service',
                    'ru' => 'SEO услуги',
                    'de' => 'SEO-Service',
                    'kk' => 'SEO қызметі',
                    'uz' => 'SEO xizmati',
                ],
                'summary' => [
                    'az' => 'Google-da yuxarı sıralar — reklam büdcəsi bitəndə dayanmayan müştəri axını.',
                    'en' => 'Top positions on Google — a stream of customers that doesn’t stop when the ad budget does.',
                    'ru' => 'Верхние позиции в Google — поток клиентов, который не исчезает вместе с рекламным бюджетом.',
                    'de' => 'Top-Positionen bei Google — ein Kundenstrom, der nicht endet, wenn das Werbebudget endet.',
                    'kk' => 'Google-дағы жоғарғы орындар — жарнама бюджеті бітерде тоқтамайтын клиент ағыны.',
                    'uz' => 'Google’dagi yuqori oʻrinlar — reklama byudjeti tugaganda toʻxtamaydigan mijoz oqimi.',
                ],
                'description' => [
                    'az' => 'Reklam ödənişi dayandığı gün müştəri axını da dayanır. SEO isə investisiyadır: bu gün görülən iş bir il sonra da müraciət gətirir. Biz müştərilərinizin real olaraq nə yazdığını araşdırır, saytınızı həmin sorğularda tapılacaq hala gətiririk və hər ay nəticəni rəqəmlərlə — mövqe, ziyarətçi, müraciət sayı ilə — hesabat şəklində təqdim edirik.',
                    'en' => 'The day you stop paying for ads, the leads stop too. SEO is an investment instead: work done today still brings enquiries a year from now. We research what your customers actually type, make your site the answer to those searches, and report the result every month in plain numbers — positions, visitors, enquiries.',
                    'ru' => 'В день, когда вы перестаёте платить за рекламу, заявки заканчиваются. SEO работает иначе: сделанное сегодня приносит обращения и через год. Мы изучаем, что клиенты действительно ищут, делаем сайт ответом на эти запросы и каждый месяц показываем результат цифрами — позиции, посетители, заявки.',
                    'de' => 'An dem Tag, an dem Sie die Anzeigen abschalten, hören auch die Anfragen auf. SEO funktioniert anders: Was heute gemacht wird, bringt auch in einem Jahr noch Anfragen. Wir recherchieren, was Ihre Kunden tatsächlich eintippen, machen Ihre Seite zur Antwort auf diese Suchen und berichten das Ergebnis monatlich in klaren Zahlen — Positionen, Besucher, Anfragen.',
                    'kk' => 'Жарнамаға төлеуді тоқтатқан күні өтініштер де тоқтайды. SEO басқаша жұмыс істейді: бүгін жасалған жұмыс бір жылдан кейін де өтініш әкеледі. Клиенттеріңіз шын мәнінде не жазатынын зерттеп, сайтыңызды сол сұрауларға жауап болатындай етеміз және нәтижені ай сайын нақты сандармен — орын, келуші, өтініш санымен — есеп түрінде ұсынамыз.',
                    'uz' => 'Reklamaga toʻlashni toʻxtatgan kuningiz murojaatlar ham toʻxtaydi. SEO esa boshqacha ishlaydi: bugun qilingan ish bir yildan keyin ham murojaat keltiradi. Mijozlaringiz aslida nima yozishini oʻrganamiz, saytingizni oʻsha soʻrovlarga javob boʻladigan holga keltiramiz va natijani har oy aniq raqamlar bilan — oʻrin, tashrifchi, murojaat soni — hisobot shaklida taqdim etamiz.',
                ],
                'features' => [
                    'az' => [
                        'Rəqiblərin hansı sorğulardan müştəri aldığının analizi',
                        'Müştərinin axtardığı mövzular üzrə səhifə və məzmun planı',
                        'Google Xəritələr və lokal axtarışda görünürlük',
                        'Aylıq hesabat: mövqe, ziyarətçi və müraciət sayı',
                        'Nəticə ölçülən hədəflər üzərində şəffaf iş',
                    ],
                    'en' => [
                        'Analysis of which searches bring your competitors customers',
                        'A page and content plan built on what buyers search for',
                        'Visibility on Google Maps and in local search',
                        'Monthly report: positions, visitors and enquiries',
                        'Transparent work against measurable targets',
                    ],
                    'ru' => [
                        'Анализ запросов, которые приносят клиентов конкурентам',
                        'План страниц и контента по реальным запросам покупателей',
                        'Видимость в Google Картах и локальном поиске',
                        'Ежемесячный отчёт: позиции, посетители, заявки',
                        'Прозрачная работа по измеримым целям',
                    ],
                    'de' => [
                        'Analyse, welche Suchanfragen Ihren Wettbewerbern Kunden bringen',
                        'Seiten- und Content-Plan auf Basis dessen, wonach Käufer suchen',
                        'Sichtbarkeit auf Google Maps und in der lokalen Suche',
                        'Monatsbericht: Positionen, Besucher und Anfragen',
                        'Transparente Arbeit an messbaren Zielen',
                    ],
                    'kk' => [
                        'Бәсекелестерге қай сұраулар клиент әкелетінінің талдауы',
                        'Сатып алушы іздейтін тақырыптар бойынша бет және мазмұн жоспары',
                        'Google Карталар мен жергілікті іздеуде көріну',
                        'Айлық есеп: орын, келуші және өтініш саны',
                        'Өлшенетін мақсаттар бойынша ашық жұмыс',
                    ],
                    'uz' => [
                        'Raqobatchilarga qaysi soʻrovlar mijoz keltirayotganining tahlili',
                        'Xaridor qidiradigan mavzular boʻyicha sahifa va kontent rejasi',
                        'Google Xaritalar va mahalliy qidiruvda koʻrinish',
                        'Oylik hisobot: oʻrin, tashrifchi va murojaat soni',
                        'Oʻlchanadigan maqsadlar boʻyicha shaffof ish',
                    ],
                ],
            ],
            [
                'slug' => 'business-automation',
                'icon' => 'heroicon-o-cog-6-tooth',
                'sort_order' => 50,
                'title' => [
                    'az' => 'Biznes avtomatlaşdırma',
                    'en' => 'Business automation',
                    'ru' => 'Автоматизация бизнеса',
                    'de' => 'Prozessautomatisierung',
                    'kk' => 'Бизнесті автоматтандыру',
                    'uz' => 'Biznesni avtomatlashtirish',
                ],
                'summary' => [
                    'az' => 'Təkrarlanan işləri sistemə tapşırın — komandanız satışa vaxt ayırsın.',
                    'en' => 'Hand repetitive work to a system so your team can spend its hours selling.',
                    'ru' => 'Передайте рутину системе — пусть команда тратит время на продажи.',
                    'de' => 'Übergeben Sie wiederkehrende Arbeit einem System, damit Ihr Team seine Stunden ins Verkaufen steckt.',
                    'kk' => 'Қайталанатын жұмысты жүйеге тапсырыңыз — командаңыз уақытын сатылымға жұмсасын.',
                    'uz' => 'Takrorlanadigan ishni tizimga topshiring — jamoangiz vaqtini savdoga sarflasin.',
                ],
                'description' => [
                    'az' => 'Sifarişin Excel-də, müraciətin WhatsApp-da, hesabatın kağızda saxlanması gündə saatlar aparır və səhvlərə yol açır. Biz əvvəlcə komandanızın vaxtını ən çox nəyin yediyini müəyyən edirik, sonra həmin işi sistemə tapşırırıq: məlumat bir yerdə toplanır, hesabat özü hazırlanır, rəhbər isə vəziyyəti bir ekranda görür.',
                    'en' => 'Orders in a spreadsheet, enquiries in WhatsApp, reports on paper — that costs hours a day and creates mistakes. We first find what eats most of your team’s time, then hand that work to a system: data lives in one place, reports build themselves, and the manager sees the whole picture on one screen.',
                    'ru' => 'Заказы в Excel, заявки в WhatsApp, отчёты на бумаге — это часы в день и постоянные ошибки. Мы сначала находим, что съедает больше всего времени команды, а затем передаём эту работу системе: данные в одном месте, отчёты формируются сами, руководитель видит картину на одном экране.',
                    'de' => 'Bestellungen in einer Tabelle, Anfragen in WhatsApp, Berichte auf Papier — das kostet täglich Stunden und erzeugt Fehler. Wir finden zuerst heraus, was die meiste Zeit Ihres Teams frisst, und übergeben diese Arbeit einem System: Daten liegen an einem Ort, Berichte entstehen von selbst, und die Führung sieht die Lage auf einem Bildschirm.',
                    'kk' => 'Тапсырыс Excel-де, өтініш WhatsApp-та, есеп қағазда сақталса, бұл күніне сағаттарды алады және қателікке жол ашады. Алдымен командаңыздың уақытын ең көп не жейтінін анықтаймыз, содан кейін сол жұмысты жүйеге тапсырамыз: дерек бір жерде жиналады, есеп өзі дайындалады, ал басшы жағдайды бір экраннан көреді.',
                    'uz' => 'Buyurtma Excel’da, murojaat WhatsApp’da, hisobot qogʻozda saqlansa, bu kuniga soatlab vaqt oladi va xatoliklarga yoʻl ochadi. Avval jamoangiz vaqtini eng koʻp nima yeyayotganini aniqlaymiz, soʻng oʻsha ishni tizimga topshiramiz: maʼlumot bir joyda toʻplanadi, hisobot oʻzi tayyorlanadi, rahbar esa holatni bitta ekranda koʻradi.',
                ],
                'features' => [
                    'az' => [
                        'Sifariş, müraciət və müştəri bazasının vahid sistemi',
                        'Əl ilə görülən təkrar işlərin avtomatlaşdırılması',
                        'WhatsApp, e-poçt və mühasibat proqramları ilə inteqrasiya',
                        'Rəhbər üçün canlı hesabat paneli',
                        'Komandanız üçün təlim və istifadə təlimatı',
                    ],
                    'en' => [
                        'One system for orders, enquiries and your customer base',
                        'Repetitive manual work automated away',
                        'Integrations with WhatsApp, email and accounting tools',
                        'A live dashboard for the person in charge',
                        'Training and a usage guide for your team',
                    ],
                    'ru' => [
                        'Единая система для заказов, заявок и базы клиентов',
                        'Автоматизация повторяющейся ручной работы',
                        'Интеграции с WhatsApp, почтой и бухгалтерией',
                        'Живая панель отчётов для руководителя',
                        'Обучение команды и инструкция по работе',
                    ],
                    'de' => [
                        'Ein System für Bestellungen, Anfragen und Ihren Kundenstamm',
                        'Wiederkehrende Handarbeit wird automatisiert',
                        'Anbindung an WhatsApp, E-Mail und Buchhaltungsprogramme',
                        'Ein Live-Dashboard für die Führungsebene',
                        'Schulung und Anwendungsleitfaden für Ihr Team',
                    ],
                    'kk' => [
                        'Тапсырыс, өтініш және клиенттер базасының бірыңғай жүйесі',
                        'Қолмен жасалатын қайталама жұмыстарды автоматтандыру',
                        'WhatsApp, электрондық пошта және бухгалтерлік бағдарламалармен интеграция',
                        'Басшыға арналған тірі есеп панелі',
                        'Командаңызға оқыту және пайдалану нұсқаулығы',
                    ],
                    'uz' => [
                        'Buyurtma, murojaat va mijozlar bazasining yagona tizimi',
                        'Qoʻlda bajariladigan takroriy ishlarni avtomatlashtirish',
                        'WhatsApp, elektron pochta va buxgalteriya dasturlari bilan integratsiya',
                        'Rahbar uchun jonli hisobot paneli',
                        'Jamoangiz uchun oʻquv va foydalanish qoʻllanmasi',
                    ],
                ],
            ],
            [
                'slug' => 'geo-ai-seo',
                'icon' => 'heroicon-o-viewfinder-circle',
                'sort_order' => 60,
                'title' => [
                    'az' => 'GEO (AI üçün SEO)',
                    'en' => 'GEO (SEO for AI)',
                    'ru' => 'GEO (SEO для AI)',
                    'de' => 'GEO (SEO für KI)',
                    'kk' => 'GEO (ЖИ үшін SEO)',
                    'uz' => 'GEO (SI uchun SEO)',
                ],
                'summary' => [
                    'az' => 'Müştəri süni intellektdən tövsiyə istəyəndə cavabda sizin adınız keçsin.',
                    'en' => 'When a customer asks an AI assistant for a recommendation, your name is in the answer.',
                    'ru' => 'Когда клиент спрашивает совета у ИИ, в ответе звучит ваше имя.',
                    'de' => 'Wenn ein Kunde einen KI-Assistenten um eine Empfehlung bittet, steht Ihr Name in der Antwort.',
                    'kk' => 'Клиент жасанды интеллекттен ұсыныс сұрағанда жауапта сіздің атыңыз аталсын.',
                    'uz' => 'Mijoz sunʼiy intellektdan tavsiya soʻraganda javobda sizning nomingiz aytilsin.',
                ],
                'description' => [
                    'az' => 'Müştərilər artıq yalnız Google-da axtarmır — «mənə yaxşı bir şirkət tövsiyə et» sualını süni intellekt köməkçilərinə verirlər və çox vaxt ilk cavabla kifayətlənirlər. Bu cavabda kimin adının keçdiyi təsadüf deyil. Biz brendiniz haqqında məlumatın internetdə AI-ın oxuya və etibar edə biləcəyi formada yerləşməsini təmin edirik ki, tövsiyə siyahısında siz olasınız.',
                    'en' => 'Customers no longer search only on Google — they ask an AI assistant to “recommend a good company” and usually act on the first answer. Whose name appears there is not an accident. We make sure the information about your brand exists online in a form AI can read and trust, so you end up on the shortlist.',
                    'ru' => 'Клиенты уже ищут не только в Google — они просят ИИ «посоветовать хорошую компанию» и чаще всего действуют по первому ответу. То, чьё имя там прозвучит, — не случайность. Мы делаем так, чтобы информация о вашем бренде была в сети в форме, которую ИИ может прочитать и которой доверяет.',
                    'de' => 'Kunden suchen nicht mehr nur bei Google — sie bitten einen KI-Assistenten, „eine gute Firma zu empfehlen“, und handeln meist nach der ersten Antwort. Wessen Name dort auftaucht, ist kein Zufall. Wir sorgen dafür, dass die Informationen über Ihre Marke online in einer Form vorliegen, die KI lesen und der sie vertrauen kann — damit Sie auf der Empfehlungsliste stehen.',
                    'kk' => 'Клиенттер енді тек Google-да іздемейді — жасанды интеллект көмекшісінен «жақсы компания ұсын» деп сұрайды және көбіне алғашқы жауап бойынша әрекет етеді. Онда кімнің аты аталатыны кездейсоқтық емес. Брендіңіз туралы ақпараттың интернетте ЖИ оқи алатын және сене алатын пішімде болуын қамтамасыз етеміз — сонда ұсыныс тізімінде сіз боласыз.',
                    'uz' => 'Mijozlar endi faqat Google’da qidirmaydi — sunʼiy intellekt yordamchisidan «yaxshi kompaniya tavsiya qil» deb soʻraydi va koʻpincha birinchi javob boʻyicha ish tutadi. U yerda kimning nomi aytilishi tasodif emas. Brendingiz haqidagi maʼlumot internetda SI oʻqiy oladigan va ishona oladigan shaklda boʻlishini taʼminlaymiz — shunda tavsiya roʻyxatida siz boʻlasiz.',
                ],
                'features' => [
                    'az' => [
                        'AI cavablarında brendinizin adının keçməsi üzərində iş',
                        'Müştərinin verdiyi suallara birbaşa cavab verən məzmun',
                        'Xidmət, qiymət və üstünlüklərin AI üçün aydın strukturu',
                        'Rəqiblərin AI görünürlüyü ilə müqayisə',
                        'Aylıq izləmə: hansı suallarda tövsiyə olunursunuz',
                    ],
                    'en' => [
                        'Work aimed at getting your brand named in AI answers',
                        'Content that answers the questions customers actually ask',
                        'Services, pricing and strengths structured so AI can read them',
                        'A comparison against your competitors’ AI visibility',
                        'Monthly tracking of the questions you get recommended for',
                    ],
                    'ru' => [
                        'Работа над тем, чтобы ИИ называл ваш бренд в ответах',
                        'Контент, который прямо отвечает на вопросы клиентов',
                        'Услуги, цены и преимущества в структуре, понятной ИИ',
                        'Сравнение с AI-видимостью конкурентов',
                        'Ежемесячный мониторинг: по каким вопросам вас советуют',
                    ],
                    'de' => [
                        'Arbeit daran, dass KI-Antworten Ihre Marke namentlich nennen',
                        'Inhalte, die die Fragen Ihrer Kunden direkt beantworten',
                        'Leistungen, Preise und Stärken so strukturiert, dass KI sie liest',
                        'Vergleich mit der KI-Sichtbarkeit Ihrer Wettbewerber',
                        'Monatliches Tracking, für welche Fragen Sie empfohlen werden',
                    ],
                    'kk' => [
                        'ЖИ жауаптарында брендіңіздің аталуы үшін жұмыс',
                        'Клиент қоятын сұрақтарға тікелей жауап беретін мазмұн',
                        'Қызмет, баға және артықшылықтардың ЖИ үшін анық құрылымы',
                        'Бәсекелестердің ЖИ көрінімділігімен салыстыру',
                        'Айлық бақылау: қандай сұрақтарда ұсынылып жатырсыз',
                    ],
                    'uz' => [
                        'SI javoblarida brendingiz nomi aytilishi ustida ish',
                        'Mijoz beradigan savollarga bevosita javob beradigan kontent',
                        'Xizmat, narx va ustunliklarning SI uchun aniq tuzilmasi',
                        'Raqobatchilarning SI koʻrinishi bilan solishtirish',
                        'Oylik kuzatuv: qaysi savollarda tavsiya etilyapsiz',
                    ],
                ],
            ],
        ];

        foreach ($services as $data) {
            Service::updateOrCreate(['slug' => $data['slug']], $data);
        }

        // Retired demo service — the catalogue is now exactly the six above.
        Service::where('slug', 'it-consultancy')->delete();
    }
}
