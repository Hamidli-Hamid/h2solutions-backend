<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * Questions specific to one service, shown on its detail page above the
 * process steps. Written for buyers who have already picked the service and
 * want the practical details — never a repeat of the generic FAQ on the
 * services hub.
 *
 * Re-running only fills the languages that are still empty, so anything an
 * editor wrote in the admin panel survives.
 *
 * Each entry is [question, answer]; run() maps it to the {question, answer}
 * shape the API and the frontend expect.
 */
class ServiceFaqSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->faq() as $slug => $byLocale) {
            $service = Service::where('slug', $slug)->first();

            if (! $service) {
                $this->command?->warn("No service [$slug] — FAQ skipped.");
                continue;
            }

            $stored = $service->getTranslations('faq');
            $touched = false;

            foreach ($byLocale as $locale => $pairs) {
                if (! empty($stored[$locale])) {
                    continue;
                }

                $service->setTranslation('faq', $locale, array_map(
                    fn (array $pair) => ['question' => $pair[0], 'answer' => $pair[1]],
                    $pairs
                ));
                $touched = true;
            }

            if ($touched) {
                $service->save();
            }
        }
    }

    /**
     * @return array<string, array<string, array<int, array{0: string, 1: string}>>>
     */
    private function faq(): array
    {
        return [
            'web-development' => [
                'az' => [
                    ['Sayt neçə səhifədən ibarət olacaq və sonradan səhifə əlavə edə bilərəmmi?', 'Standart korporativ paketə ana səhifə, xidmətlər, haqqımızda, əlaqə və bloq daxildir. Yeni səhifəni admin paneldən özünüz əlavə edə bilərsiniz; xüsusi dizayn tələb edən bölmələri isə biz hazırlayırıq.'],
                    ['Mətnləri və şəkilləri kim hazırlayır?', 'Strukturu və ilkin mətnləri biz veririk; hazır kontentiniz varsa onu uyğunlaşdırırıq. Peşəkar kopiraytinq və foto seçimi istəyə görə layihəyə əlavə olunur.'],
                    ['Saytı çoxdilli etmək mümkündürmü?', 'Bəli. Dil dəstəyi memarlığa əvvəlcədən qoyulur: hər dil üçün ayrıca URL və hreflang qurulur ki, axtarış sistemləri versiyaları düzgün tanısın.'],
                    ['Sayt nə qədər sürətli açılacaq?', 'Səhifələr Core Web Vitals hədəflərinə uyğun hazırlanır: şəkillər avtomatik optimallaşdırılır, məzmun server tərəfdə hazırlanır. PageSpeed nəticələrini təhvildən əvvəl sizinlə paylaşırıq.'],
                ],
                'en' => [
                    ['How many pages does the site include, and can I add more later?', 'The standard corporate package covers home, services, about, contact and a blog. You can add new pages yourself from the admin panel; sections that need custom design are built by us.'],
                    ['Who writes the text and picks the images?', 'We provide the structure and draft copy; if you already have content we adapt it. Professional copywriting and photo selection can be added to the project on request.'],
                    ['Can the site be multilingual?', 'Yes. Language support is designed in from the start: every language gets its own URL and hreflang tags so search engines index the versions correctly.'],
                    ['How fast will the site load?', 'Pages are built against Core Web Vitals targets: images are optimised automatically and content is rendered on the server. We share the PageSpeed results with you before handover.'],
                ],
                'ru' => [
                    ['Сколько страниц включает сайт и можно ли добавить новые позже?', 'Стандартный корпоративный пакет включает главную, услуги, о компании, контакты и блог. Новые страницы вы добавляете сами через админ-панель; разделы с индивидуальным дизайном делаем мы.'],
                    ['Кто пишет тексты и подбирает изображения?', 'Структуру и черновые тексты даём мы; готовый контент адаптируем. Профессиональный копирайтинг и подбор фото добавляются в проект по запросу.'],
                    ['Можно ли сделать сайт многоязычным?', 'Да. Поддержка языков закладывается в архитектуру сразу: у каждого языка свой URL и hreflang, чтобы поисковики правильно распознавали версии.'],
                    ['Насколько быстро будет открываться сайт?', 'Страницы делаются под целевые показатели Core Web Vitals: изображения оптимизируются автоматически, контент рендерится на сервере. Результаты PageSpeed показываем до сдачи.'],
                ],
                'de' => [
                    ['Wie viele Seiten umfasst die Website und lassen sich später weitere ergänzen?', 'Das Standardpaket enthält Startseite, Leistungen, Über uns, Kontakt und Blog. Neue Seiten legen Sie selbst im Admin-Panel an; Bereiche mit eigenem Design übernehmen wir.'],
                    ['Wer schreibt die Texte und wählt die Bilder aus?', 'Struktur und Textentwürfe liefern wir; vorhandene Inhalte passen wir an. Professionelles Texten und Bildauswahl lassen sich auf Wunsch dazubuchen.'],
                    ['Kann die Website mehrsprachig sein?', 'Ja. Die Sprachunterstützung wird von Anfang an eingeplant: Jede Sprache erhält eigene URLs und hreflang-Angaben, damit Suchmaschinen die Versionen korrekt zuordnen.'],
                    ['Wie schnell lädt die Website?', 'Die Seiten werden auf die Core-Web-Vitals-Ziele hin gebaut: Bilder werden automatisch optimiert, Inhalte serverseitig gerendert. Die PageSpeed-Ergebnisse zeigen wir vor der Übergabe.'],
                ],
                'kk' => [
                    ['Сайт неше беттен тұрады және кейін жаңа бет қосуға бола ма?', 'Стандартты корпоративтік пакетке басты бет, қызметтер, біз туралы, байланыс және блог кіреді. Жаңа бетті админ панельден өзіңіз қоса аласыз; жеке дизайн қажет бөлімдерді біз жасаймыз.'],
                    ['Мәтінді кім жазады, суретті кім таңдайды?', 'Құрылым мен алғашқы мәтіндерді біз береміз; дайын контентіңіз болса, оны бейімдейміз. Кәсіби копирайтинг пен фото таңдау сұрауыңыз бойынша жобаға қосылады.'],
                    ['Сайтты көптілді етуге бола ма?', 'Иә. Тіл қолдауы архитектураға бастапқыда салынады: әр тілдің жеке URL мекенжайы және hreflang белгісі болады, сонда іздеу жүйелері нұсқаларды дұрыс таниды.'],
                    ['Сайт қаншалықты жылдам ашылады?', 'Беттер Core Web Vitals көрсеткіштеріне сай жасалады: суреттер автоматты оңтайландырылады, мазмұн сервер жағында дайындалады. PageSpeed нәтижелерін тапсырар алдында көрсетеміз.'],
                ],
                'uz' => [
                    ['Sayt nechta sahifadan iborat va keyin yangi sahifa qoʻshsa boʻladimi?', 'Standart korporativ paketga bosh sahifa, xizmatlar, biz haqimizda, aloqa va blog kiradi. Yangi sahifani admin paneldan oʻzingiz qoʻshasiz; maxsus dizayn talab qiladigan boʻlimlarni biz tayyorlaymiz.'],
                    ['Matnlarni kim yozadi va rasmlarni kim tanlaydi?', 'Tuzilma va dastlabki matnlarni biz beramiz; tayyor kontentingiz boʻlsa, uni moslashtiramiz. Professional kopirayting va foto tanlash soʻrovga koʻra loyihaga qoʻshiladi.'],
                    ['Saytni koʻp tilli qilish mumkinmi?', 'Ha. Til qoʻllab-quvvatlashi arxitekturaga boshidan qoʻyiladi: har bir til uchun alohida URL va hreflang belgilanadi, shunda qidiruv tizimlari versiyalarni toʻgʻri taniydi.'],
                    ['Sayt qanchalik tez ochiladi?', 'Sahifalar Core Web Vitals koʻrsatkichlariga moslab quriladi: rasmlar avtomatik optimallashtiriladi, kontent server tomonida tayyorlanadi. PageSpeed natijalarini topshirishdan oldin koʻrsatamiz.'],
                ],
            ],

            'mobile-apps' => [
                'az' => [
                    ['Tətbiq iOS və Android üçün ayrıca yazılırmı?', 'Xeyr, hər iki platforma üçün vahid kod bazası qururuq. Bu, büdcəni azaldır və yeni funksiyanın hər iki mağazada eyni vaxtda çıxmasını təmin edir.'],
                    ['App Store və Google Play-ə yerləşdirməni siz edirsiniz?', 'Bəli. Developer hesablarının açılması, mağaza səhifəsinin hazırlanması və moderasiyadan keçmə tam bizim üzərimizdədir; hesablar sizin adınıza qeydiyyatdan keçir.'],
                    ['Tətbiq mövcud saytımız və ya anbar sistemimizlə işləyəcəkmi?', 'Bəli. Tətbiq API vasitəsilə mövcud sisteminizə qoşulur — sifariş, məhsul və müştəri məlumatları tək mənbədə qalır.'],
                    ['Mağaza qaydaları dəyişəndə tətbiq yenilənməlidirmi?', 'Bəli, Apple və Google tələbləri ildə bir neçə dəfə yeniləyir. Dəstək paketi bu dəyişikliklərin izlənməsini əhatə edir ki, tətbiq mağazadan düşməsin.'],
                ],
                'en' => [
                    ['Is the app written separately for iOS and Android?', 'No. We build one codebase for both platforms, which lowers the budget and lets a new feature reach both stores at the same time.'],
                    ['Do you handle App Store and Google Play submission?', 'Yes. Opening the developer accounts, preparing the store listing and passing review are entirely on us; the accounts are registered in your name.'],
                    ['Will the app work with our existing website or stock system?', 'Yes. The app connects to your systems through an API, so orders, products and customer data stay in a single source.'],
                    ['Does the app need updating when store rules change?', 'Yes — Apple and Google revise their requirements several times a year. The support package covers tracking those changes so the app is never pulled from a store.'],
                ],
                'ru' => [
                    ['Приложение пишется отдельно для iOS и Android?', 'Нет. Мы делаем одну кодовую базу для обеих платформ: это снижает бюджет и позволяет выпускать новинки в оба магазина одновременно.'],
                    ['Публикацию в App Store и Google Play берёте на себя?', 'Да. Открытие аккаунтов разработчика, оформление страницы в магазине и прохождение модерации — полностью на нас; аккаунты регистрируются на вас.'],
                    ['Будет ли приложение работать с нашим сайтом или складской системой?', 'Да. Приложение подключается к вашим системам через API: заказы, товары и данные клиентов остаются в едином источнике.'],
                    ['Нужно ли обновлять приложение при изменении правил магазинов?', 'Да, Apple и Google меняют требования несколько раз в год. Пакет поддержки включает отслеживание этих изменений, чтобы приложение не сняли с публикации.'],
                ],
                'de' => [
                    ['Wird die App für iOS und Android getrennt entwickelt?', 'Nein. Wir bauen eine Codebasis für beide Plattformen — das senkt das Budget und bringt neue Funktionen gleichzeitig in beide Stores.'],
                    ['Übernehmen Sie die Veröffentlichung im App Store und bei Google Play?', 'Ja. Entwicklerkonten, Store-Eintrag und Review-Prozess übernehmen wir vollständig; die Konten laufen auf Ihren Namen.'],
                    ['Funktioniert die App mit unserer bestehenden Website oder Warenwirtschaft?', 'Ja. Die App wird über eine API angebunden, sodass Bestellungen, Produkte und Kundendaten aus einer Quelle kommen.'],
                    ['Muss die App aktualisiert werden, wenn sich Store-Regeln ändern?', 'Ja — Apple und Google ändern ihre Anforderungen mehrmals jährlich. Das Support-Paket umfasst die Beobachtung dieser Änderungen, damit die App nicht entfernt wird.'],
                ],
                'kk' => [
                    ['Қосымша iOS пен Android үшін бөлек жазыла ма?', 'Жоқ. Екі платформаға бір код базасын құрамыз: бұл бюджетті азайтады және жаңа функция екі дүкенге бір мезгілде шығады.'],
                    ['App Store мен Google Play-ге жариялауды сіз атқарасыз ба?', 'Иә. Әзірлеуші аккаунттарын ашу, дүкен парағын дайындау және модерациядан өту толықтай бізде; аккаунттар сіздің атыңызға тіркеледі.'],
                    ['Қосымша бізде бар сайт немесе қойма жүйесімен жұмыс істей ме?', 'Иә. Қосымша API арқылы жүйелеріңізге қосылады: тапсырыс, өнім және клиент деректері бір дереккөзде қалады.'],
                    ['Дүкен ережелері өзгергенде қосымшаны жаңарту керек пе?', 'Иә, Apple мен Google талаптарын жылына бірнеше рет жаңартады. Қолдау пакеті осы өзгерістерді бақылауды қамтиды — қосымша дүкеннен алынып қалмайды.'],
                ],
                'uz' => [
                    ['Ilova iOS va Android uchun alohida yoziladimi?', 'Yoʻq. Ikkala platforma uchun bitta kod bazasini quramiz: bu byudjetni kamaytiradi va yangi funksiya ikkala doʻkonga bir vaqtda chiqadi.'],
                    ['App Store va Google Play’ga joylashtirishni siz bajarasizmi?', 'Ha. Dasturchi hisoblarini ochish, doʻkon sahifasini tayyorlash va moderatsiyadan oʻtish toʻliq bizda; hisoblar sizning nomingizga roʻyxatdan oʻtadi.'],
                    ['Ilova mavjud saytimiz yoki ombor tizimimiz bilan ishlaydimi?', 'Ha. Ilova API orqali tizimlaringizga ulanadi: buyurtma, mahsulot va mijoz maʼlumotlari yagona manbada qoladi.'],
                    ['Doʻkon qoidalari oʻzgarganda ilovani yangilash kerakmi?', 'Ha, Apple va Google talablarini yiliga bir necha marta yangilaydi. Qoʻllab-quvvatlash paketi shu oʻzgarishlarni kuzatishni oʻz ichiga oladi — ilova doʻkondan olib tashlanmaydi.'],
                ],
            ],

            'e-commerce' => [
                'az' => [
                    ['Hansı ödəniş üsulları qoşula bilər?', 'Yerli bank ekvayrinqi, kart ödənişi, hissəli ödəniş və qapıda nağd ödəniş — hamısı qoşula bilər. Bankın tələb etdiyi texniki sənədləri biz hazırlayırıq.'],
                    ['Məhsul sayı artanda mağaza yavaşlayacaqmı?', 'Xeyr. Filtr və axtarış minlərlə məhsula hesablanmış memarlıqla qurulur, siyahılar və şəkillər keşlənir.'],
                    ['Mövcud mağazamızı yeni platformaya köçürə bilərsinizmi?', 'Bəli. Məhsul, müştəri və sifariş tarixçəsi köçürülür, köhnə URL-lər 301 yönləndirmə ilə saxlanılır ki, qazanılmış SEO itməsin.'],
                    ['Anbar və mühasibat proqramları ilə inteqrasiya mümkündürmü?', 'Bəli. 1C, Excel ixracı və ya API-si olan istənilən anbar sistemi ilə sinxronizasiya qururuq — qalıq və qiymətlər avtomatik yenilənir.'],
                ],
                'en' => [
                    ['Which payment methods can be connected?', 'Local bank acquiring, card payments, instalments and cash on delivery can all be connected. We prepare the technical paperwork the bank asks for.'],
                    ['Will the store slow down as the catalogue grows?', 'No. Filtering and search are designed for catalogues of thousands of products, and listings and images are cached.'],
                    ['Can you migrate our existing store to a new platform?', 'Yes. Products, customers and order history are migrated, and old URLs are kept alive with 301 redirects so the SEO you have built is not lost.'],
                    ['Can it integrate with our stock and accounting software?', 'Yes. We can sync with 1C, an Excel export or any warehouse system with an API, so stock levels and prices update automatically.'],
                ],
                'ru' => [
                    ['Какие способы оплаты можно подключить?', 'Эквайринг местных банков, оплата картой, рассрочка и наличные при доставке — всё подключается. Технические документы для банка готовим мы.'],
                    ['Замедлится ли магазин при большом каталоге?', 'Нет. Фильтры и поиск рассчитаны на тысячи товаров, а списки и изображения кэшируются.'],
                    ['Можете перенести действующий магазин на новую платформу?', 'Да. Переносим товары, клиентов и историю заказов, а старые URL сохраняем через 301-редиректы, чтобы не потерять накопленное SEO.'],
                    ['Возможна ли интеграция со складом и бухгалтерией?', 'Да. Настраиваем синхронизацию с 1С, выгрузкой Excel или любой складской системой с API — остатки и цены обновляются автоматически.'],
                ],
                'de' => [
                    ['Welche Zahlungsarten lassen sich anbinden?', 'Bank-Acquiring, Kartenzahlung, Ratenzahlung und Barzahlung bei Lieferung sind alle möglich. Die technischen Unterlagen für die Bank erstellen wir.'],
                    ['Wird der Shop langsamer, wenn der Katalog wächst?', 'Nein. Filter und Suche sind für Kataloge mit Tausenden Produkten ausgelegt, Listen und Bilder werden gecacht.'],
                    ['Können Sie unseren bestehenden Shop auf eine neue Plattform migrieren?', 'Ja. Produkte, Kunden und Bestellhistorie werden migriert, alte URLs bleiben per 301-Weiterleitung erhalten, damit die aufgebaute SEO-Leistung nicht verloren geht.'],
                    ['Ist eine Anbindung an Lager und Buchhaltung möglich?', 'Ja. Wir synchronisieren mit 1C, Excel-Exporten oder jedem Warenwirtschaftssystem mit API — Bestände und Preise aktualisieren sich automatisch.'],
                ],
                'kk' => [
                    ['Қандай төлем тәсілдерін қосуға болады?', 'Жергілікті банк эквайрингі, карта төлемі, бөліп төлеу және жеткізу кезінде қолма-қол төлем — бәрін қосуға болады. Банк сұрайтын техникалық құжаттарды біз дайындаймыз.'],
                    ['Каталог үлкейгенде дүкен баяулай ма?', 'Жоқ. Сүзгі мен іздеу мыңдаған өнімге есептелген, ал тізімдер мен суреттер кэштеледі.'],
                    ['Қазіргі дүкенімізді жаңа платформаға көшіре аласыз ба?', 'Иә. Өнім, клиент және тапсырыс тарихы көшіріледі, ескі URL-дер 301 бағыттауымен сақталады — жинақталған SEO жоғалмайды.'],
                    ['Қойма және бухгалтерия бағдарламаларымен интеграция мүмкін бе?', 'Иә. 1С, Excel экспорты немесе API-і бар кез келген қойма жүйесімен синхрондау орнатамыз — қалдық пен баға автоматты жаңарады.'],
                ],
                'uz' => [
                    ['Qanday toʻlov usullarini ulash mumkin?', 'Mahalliy bank ekvayringi, karta toʻlovi, boʻlib toʻlash va yetkazishda naqd toʻlov — barchasi ulanadi. Bank soʻraydigan texnik hujjatlarni biz tayyorlaymiz.'],
                    ['Katalog kattalashganda doʻkon sekinlashadimi?', 'Yoʻq. Filtr va qidiruv minglab mahsulotga moʻljallangan, roʻyxat va rasmlar keshlanadi.'],
                    ['Mavjud doʻkonimizni yangi platformaga koʻchira olasizmi?', 'Ha. Mahsulot, mijoz va buyurtma tarixi koʻchiriladi, eski URL manzillari 301 yoʻnaltirish bilan saqlanadi — toʻplangan SEO yoʻqolmaydi.'],
                    ['Ombor va buxgalteriya dasturlari bilan integratsiya mumkinmi?', 'Ha. 1C, Excel eksporti yoki API’si bor har qanday ombor tizimi bilan sinxronlash oʻrnatamiz — qoldiq va narxlar avtomatik yangilanadi.'],
                ],
            ],

            'seo-optimization' => [
                'az' => [
                    ['İlk nəticələr nə vaxt görünür?', 'Texniki düzəlişlərin təsiri 4–6 həftə ərzində hiss olunur; rəqabətli sorğularda sabit yüksəliş adətən 3–6 ay çəkir. Mövqe dəyişməsini hər ay hesabatla göstəririk.'],
                    ['Google-da birinci yerə zəmanət verirsinizmi?', 'Xeyr, bunu heç bir vicdanlı agentlik zəmanət edə bilməz. Bizim öhdəliyimiz razılaşdırılmış sorğular üzrə ölçülə bilən irəliləyiş və şəffaf hesabatdır.'],
                    ['Saytı siz hazırlamamısınız — yenə də SEO edə bilərsinizmi?', 'Bəli. Mövcud saytın auditini aparırıq və düzəlişləri ya tapşırıq siyahısı şəklində komandanıza veririk, ya da giriş verildikdə özümüz tətbiq edirik.'],
                    ['Məzmunun yazılmasını da öhdənizə götürürsünüzmü?', 'Bəli. Açar söz araşdırmasına əsasən məzmun planı hazırlayır, mətnləri yazır və optimallaşdırılmış səhifələri dərc edirik.'],
                ],
                'en' => [
                    ['When do the first results appear?', 'Technical fixes show an effect within 4–6 weeks; steady growth on competitive queries usually takes 3–6 months. Position changes are reported every month.'],
                    ['Do you guarantee first place on Google?', 'No, and no honest agency can. What we commit to is measurable progress on the agreed queries and transparent monthly reporting.'],
                    ['Our site was not built by you — can you still do SEO?', 'Yes. We audit the existing site and either hand the fixes to your team as a task list or implement them ourselves once we have access.'],
                    ['Do you write the content as well?', 'Yes. We build a content plan from keyword research, write the copy and publish the optimised pages.'],
                ],
                'ru' => [
                    ['Когда появятся первые результаты?', 'Эффект технических правок заметен через 4–6 недель; устойчивый рост по конкурентным запросам обычно занимает 3–6 месяцев. Изменение позиций показываем ежемесячно.'],
                    ['Гарантируете ли первое место в Google?', 'Нет, и ни одно добросовестное агентство этого не гарантирует. Мы отвечаем за измеримый прогресс по согласованным запросам и прозрачную отчётность.'],
                    ['Сайт делали не вы — сможете заняться SEO?', 'Да. Проводим аудит существующего сайта и либо передаём правки вашей команде списком задач, либо внедряем сами при наличии доступа.'],
                    ['Контент тоже пишете вы?', 'Да. Составляем контент-план на основе анализа запросов, пишем тексты и публикуем оптимизированные страницы.'],
                ],
                'de' => [
                    ['Wann zeigen sich die ersten Ergebnisse?', 'Technische Korrekturen wirken innerhalb von 4–6 Wochen; stabile Zuwächse bei umkämpften Suchbegriffen dauern meist 3–6 Monate. Positionsänderungen berichten wir monatlich.'],
                    ['Garantieren Sie Platz eins bei Google?', 'Nein, und keine seriöse Agentur kann das. Wir verpflichten uns zu messbarem Fortschritt bei den vereinbarten Suchbegriffen und transparenter Berichterstattung.'],
                    ['Die Website stammt nicht von Ihnen — können Sie trotzdem SEO machen?', 'Ja. Wir auditieren die bestehende Seite und übergeben die Korrekturen entweder als Aufgabenliste an Ihr Team oder setzen sie mit Zugang selbst um.'],
                    ['Schreiben Sie auch die Inhalte?', 'Ja. Wir erstellen einen Contentplan auf Basis der Keyword-Recherche, schreiben die Texte und veröffentlichen die optimierten Seiten.'],
                ],
                'kk' => [
                    ['Алғашқы нәтиже қашан көрінеді?', 'Техникалық түзетулердің әсері 4–6 аптада байқалады; бәсекелі сұраулар бойынша тұрақты өсу әдетте 3–6 ай алады. Орын өзгерісін ай сайын есеппен көрсетеміз.'],
                    ['Google-да бірінші орынға кепілдік бересіз бе?', 'Жоқ, мұны бірде-бір адал агенттік кепілдей алмайды. Біздің міндетіміз — келісілген сұраулар бойынша өлшенетін ілгерілеу және ашық есеп.'],
                    ['Сайтты сіз жасамағансыз — SEO жасай аласыз ба?', 'Иә. Бар сайтқа аудит жүргіземіз және түзетулерді не тапсырма тізімі ретінде командаңызға береміз, не қолжетімділік берілсе өзіміз енгіземіз.'],
                    ['Контентті де сіз жазасыз ба?', 'Иә. Кілт сөз талдауына сүйеніп мазмұн жоспарын жасаймыз, мәтіндерді жазып, оңтайландырылған беттерді жариялаймыз.'],
                ],
                'uz' => [
                    ['Birinchi natijalar qachon koʻrinadi?', 'Texnik tuzatishlarning taʼsiri 4–6 hafta ichida seziladi; raqobatli soʻrovlarda barqaror oʻsish odatda 3–6 oy oladi. Oʻrin oʻzgarishini har oy hisobotda koʻrsatamiz.'],
                    ['Google’da birinchi oʻrinni kafolatlaysizmi?', 'Yoʻq, buni birorta halol agentlik kafolatlay olmaydi. Bizning majburiyatimiz — kelishilgan soʻrovlar boʻyicha oʻlchanadigan oʻsish va shaffof hisobot.'],
                    ['Saytni siz qurmagansiz — baribir SEO qila olasizmi?', 'Ha. Mavjud saytga audit oʻtkazamiz va tuzatishlarni yo vazifalar roʻyxati sifatida jamoangizga beramiz, yo kirish berilsa oʻzimiz joriy qilamiz.'],
                    ['Kontentni ham siz yozasizmi?', 'Ha. Kalit soʻz tahliliga asoslanib kontent rejasini tuzamiz, matnlarni yozamiz va optimallashtirilgan sahifalarni chop etamiz.'],
                ],
            ],

            'business-automation' => [
                'az' => [
                    ['Hazırda istifadə etdiyimiz proqramları dəyişməli olacağıqmı?', 'Çox vaxt yox. Əvvəlcə mövcud alətləri inteqrasiya etməyə çalışırıq; əvəzləməni yalnız sistem darboğaz yaratdıqda təklif edirik.'],
                    ['Layihə komandamızın işini dayandıracaqmı?', 'Xeyr. Keçid mərhələlərlə aparılır: yeni sistem köhnə ilə paralel işə salınır, məlumat köçürülür, komanda öyrədilir və yalnız sonra köhnə proses dayandırılır.'],
                    ['Məlumatlarımızın təhlükəsizliyi necə təmin olunur?', 'İstifadəçi rolları və icazələr, gündəlik ehtiyat nüsxə və şifrələnmiş bağlantı standart daxildir. İstəsəniz, sistem öz serverinizdə yerləşdirilə bilər.'],
                    ['Sonradan yeni funksiya əlavə etmək nə qədər çətindir?', 'Sistem modul şəklində qurulur: yeni bölmə mövcud məlumata toxunmadan əlavə olunur. Belə əlavələr dəstək paketi çərçivəsində planlaşdırılır.'],
                ],
                'en' => [
                    ['Will we have to replace the software we already use?', 'Usually not. We first try to integrate the tools you have; a replacement is proposed only where the existing system is the bottleneck.'],
                    ['Will the project interrupt our team’s work?', 'No. The switch happens in stages: the new system runs alongside the old one, data is migrated, the team is trained, and only then is the old process retired.'],
                    ['How is our data kept safe?', 'User roles and permissions, daily backups and an encrypted connection are standard. The system can also be hosted on your own server if you prefer.'],
                    ['How hard is it to add a new function later?', 'The system is built in modules, so a new section is added without disturbing existing data. Such additions are planned within the support package.'],
                ],
                'ru' => [
                    ['Придётся ли менять уже используемые программы?', 'Чаще всего нет. Сначала пытаемся интегрировать существующие инструменты; замену предлагаем только там, где система становится узким местом.'],
                    ['Остановит ли проект работу команды?', 'Нет. Переход поэтапный: новая система запускается параллельно старой, данные переносятся, команда обучается, и только затем старый процесс отключается.'],
                    ['Как обеспечивается безопасность данных?', 'Роли и права доступа, ежедневные резервные копии и шифрованное соединение входят в стандарт. При желании систему можно разместить на вашем сервере.'],
                    ['Насколько сложно добавить новую функцию позже?', 'Система строится модулями: новый раздел добавляется, не затрагивая существующие данные. Такие доработки планируются в рамках пакета поддержки.'],
                ],
                'de' => [
                    ['Müssen wir unsere bisherige Software ersetzen?', 'Meist nicht. Wir versuchen zuerst, die vorhandenen Werkzeuge anzubinden; einen Austausch schlagen wir nur vor, wo das System zum Engpass wird.'],
                    ['Unterbricht das Projekt die Arbeit unseres Teams?', 'Nein. Der Wechsel erfolgt schrittweise: Das neue System läuft parallel zum alten, Daten werden migriert, das Team wird geschult — erst danach wird der alte Prozess abgelöst.'],
                    ['Wie werden unsere Daten geschützt?', 'Benutzerrollen und Rechte, tägliche Backups und eine verschlüsselte Verbindung gehören zum Standard. Auf Wunsch läuft das System auch auf Ihrem eigenen Server.'],
                    ['Wie aufwendig ist es, später eine neue Funktion zu ergänzen?', 'Das System ist modular aufgebaut, ein neuer Bereich kommt hinzu, ohne bestehende Daten anzutasten. Solche Erweiterungen werden im Support-Paket eingeplant.'],
                ],
                'kk' => [
                    ['Қазір қолданып жүрген бағдарламаларды ауыстыру керек пе?', 'Көбіне жоқ. Алдымен бар құралдарды интеграциялауға тырысамыз; ауыстыруды жүйе кедергі болғанда ғана ұсынамыз.'],
                    ['Жоба команданың жұмысын тоқтата ма?', 'Жоқ. Ауысу кезең-кезеңімен жүреді: жаңа жүйе ескісімен қатар іске қосылады, дерек көшіріледі, команда оқытылады, содан кейін ғана ескі процесс тоқтатылады.'],
                    ['Деректеріміздің қауіпсіздігі қалай қамтамасыз етіледі?', 'Пайдаланушы рөлдері мен рұқсаттар, күнделікті сақтық көшірме және шифрланған байланыс — стандарт. Қаласаңыз, жүйені өз серверіңізде орналастыруға болады.'],
                    ['Кейін жаңа функция қосу қаншалықты қиын?', 'Жүйе модуль түрінде құрылады: жаңа бөлім бар деректі бұзбай қосылады. Мұндай толықтырулар қолдау пакеті аясында жоспарланады.'],
                ],
                'uz' => [
                    ['Hozir foydalanayotgan dasturlarni almashtirish kerakmi?', 'Koʻpincha yoʻq. Avval mavjud vositalarni integratsiya qilishga harakat qilamiz; almashtirishni tizim toʻsiq boʻlgandagina taklif qilamiz.'],
                    ['Loyiha jamoamiz ishini toʻxtatadimi?', 'Yoʻq. Oʻtish bosqichma-bosqich boʻladi: yangi tizim eskisi bilan parallel ishga tushadi, maʼlumot koʻchiriladi, jamoa oʻqitiladi va shundan keyingina eski jarayon toʻxtatiladi.'],
                    ['Maʼlumotlarimiz xavfsizligi qanday taʼminlanadi?', 'Foydalanuvchi rollari va ruxsatlar, kunlik zaxira nusxa va shifrlangan ulanish — standart. Xohlasangiz, tizim oʻz serveringizda joylashtiriladi.'],
                    ['Keyinchalik yangi funksiya qoʻshish qanchalik qiyin?', 'Tizim modullar shaklida quriladi: yangi boʻlim mavjud maʼlumotga tegmasdan qoʻshiladi. Bunday qoʻshimchalar qoʻllab-quvvatlash paketi doirasida rejalashtiriladi.'],
                ],
            ],

            'geo-ai-seo' => [
                'az' => [
                    ['GEO ənənəvi SEO-dan nə ilə fərqlənir?', 'SEO saytın axtarış nəticələrindəki sırasına, GEO isə brendinizin süni intellekt cavablarında adının keçməsinə yönəlir. Baza texniki iş ortaqdır, məzmunun strukturu və mənbə siqnalları isə fərqlidir.'],
                    ['Görünürlük hansı platformalarda ölçülür?', 'ChatGPT, Gemini, Perplexity və Google-un AI cavabları izlənir; hansı suallarda tövsiyə olunduğunuz hər ay hesabatda göstərilir.'],
                    ['Nəticəni necə yoxlaya bilərik?', 'Razılaşdırılmış sual siyahısı üzrə aylıq ölçmə aparılır: adınızın cavabda keçmə tezliyi, hansı kontekstdə keçdiyi və rəqiblərlə müqayisə qeydə alınır.'],
                    ['Bunun üçün ayrıca sayt lazımdırmı?', 'Xeyr. Mövcud sayt üzərində işləyirik: xidmət, qiymət və üstünlüklər AI-ın oxuya biləcəyi struktura salınır, xarici mənbələrdəki məlumatlar isə uyğunlaşdırılır.'],
                ],
                'en' => [
                    ['How is GEO different from traditional SEO?', 'SEO aims at ranking in search results; GEO aims at your brand being named inside AI answers. The technical groundwork overlaps, but the content structure and source signals differ.'],
                    ['Which platforms is visibility measured on?', 'We track ChatGPT, Gemini, Perplexity and Google’s AI answers, and report every month which questions you get recommended for.'],
                    ['How can we verify the result?', 'Measurement runs monthly against an agreed list of questions: how often your name appears, in what context and how that compares with competitors.'],
                    ['Do we need a separate website for this?', 'No. We work on your existing site: services, pricing and strengths are restructured so AI can read them, and the information about you on external sources is aligned.'],
                ],
                'ru' => [
                    ['Чем GEO отличается от обычного SEO?', 'SEO работает на позиции в поиске, GEO — на то, чтобы ваш бренд назывался в ответах ИИ. Базовая техническая работа общая, но структура контента и сигналы источников разные.'],
                    ['На каких платформах измеряется видимость?', 'Отслеживаем ChatGPT, Gemini, Perplexity и AI-ответы Google; ежемесячно отчитываемся, по каким вопросам вас советуют.'],
                    ['Как мы можем проверить результат?', 'Замеры проводятся ежемесячно по согласованному списку вопросов: как часто звучит ваше имя, в каком контексте и как это выглядит на фоне конкурентов.'],
                    ['Нужен ли для этого отдельный сайт?', 'Нет. Работаем на существующем сайте: услуги, цены и преимущества переводим в структуру, понятную ИИ, и приводим в порядок информацию о вас на внешних ресурсах.'],
                ],
                'de' => [
                    ['Worin unterscheidet sich GEO von klassischem SEO?', 'SEO zielt auf Rankings in den Suchergebnissen, GEO darauf, dass Ihre Marke in KI-Antworten genannt wird. Die technische Grundlage überschneidet sich, Content-Struktur und Quellensignale unterscheiden sich.'],
                    ['Auf welchen Plattformen wird die Sichtbarkeit gemessen?', 'Wir verfolgen ChatGPT, Gemini, Perplexity und die KI-Antworten von Google und berichten monatlich, für welche Fragen Sie empfohlen werden.'],
                    ['Wie können wir das Ergebnis überprüfen?', 'Gemessen wird monatlich anhand einer abgestimmten Fragenliste: wie oft Ihr Name erscheint, in welchem Kontext und im Vergleich zu Wettbewerbern.'],
                    ['Brauchen wir dafür eine separate Website?', 'Nein. Wir arbeiten auf Ihrer bestehenden Seite: Leistungen, Preise und Stärken werden so strukturiert, dass KI sie lesen kann, und die Angaben über Sie auf externen Quellen werden abgeglichen.'],
                ],
                'kk' => [
                    ['GEO дәстүрлі SEO-дан немен ерекшеленеді?', 'SEO іздеу нәтижелеріндегі орынға, GEO жасанды интеллект жауаптарында брендіңіздің аталуына бағытталған. Негізгі техникалық жұмыс ортақ, ал мазмұн құрылымы мен дереккөз сигналдары бөлек.'],
                    ['Көрінімділік қай платформаларда өлшенеді?', 'ChatGPT, Gemini, Perplexity және Google-дың ЖИ жауаптарын бақылаймыз; қандай сұрақтарда ұсынылғаныңызды ай сайын есеппен береміз.'],
                    ['Нәтижені қалай тексере аламыз?', 'Өлшеу келісілген сұрақтар тізімі бойынша ай сайын жүргізіледі: атыңыздың қаншалықты жиі аталғаны, қандай контексте аталғаны және бәсекелестермен салыстыруы тіркеледі.'],
                    ['Бұл үшін бөлек сайт керек пе?', 'Жоқ. Бар сайтпен жұмыс істейміз: қызмет, баға және артықшылықтар ЖИ оқи алатын құрылымға келтіріледі, сыртқы дереккөздердегі мәліметтер үйлестіріледі.'],
                ],
                'uz' => [
                    ['GEO anʼanaviy SEO’dan nimasi bilan farq qiladi?', 'SEO qidiruv natijalaridagi oʻringa, GEO esa brendingiz sunʼiy intellekt javoblarida tilga olinishiga qaratilgan. Asosiy texnik ish umumiy, kontent tuzilmasi va manba signallari esa boshqacha.'],
                    ['Koʻrinish qaysi platformalarda oʻlchanadi?', 'ChatGPT, Gemini, Perplexity va Google’ning SI javoblarini kuzatamiz; qaysi savollarda tavsiya etilayotganingizni har oy hisobotda beramiz.'],
                    ['Natijani qanday tekshira olamiz?', 'Oʻlchov kelishilgan savollar roʻyxati boʻyicha har oy oʻtkaziladi: nomingiz qanchalik tez-tez tilga olinishi, qanday kontekstda va raqobatchilarga nisbatan qanday koʻrinishi qayd etiladi.'],
                    ['Buning uchun alohida sayt kerakmi?', 'Yoʻq. Mavjud sayt ustida ishlaymiz: xizmat, narx va ustunliklar SI oʻqiy oladigan tuzilmaga keltiriladi, tashqi manbalardagi maʼlumotlar moslashtiriladi.'],
                ],
            ],
        ];
    }
}
