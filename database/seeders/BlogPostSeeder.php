<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Starter articles so the /blog pages have content to render. Bodies are the
 * same HTML the admin RichEditor produces — edit or replace them from the
 * panel; the slugs are what the frontend links to.
 */
class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $authorId = User::query()->orderBy('id')->value('id');

        $posts = [
            [
                'slug' => 'sayt-suretinin-satisa-tesiri',
                'read_minutes' => 6,
                'published_at' => now()->subDays(6),
                'title' => [
                    'az' => 'Saytın sürəti satışa necə təsir edir?',
                    'en' => 'How site speed actually affects your sales',
                    'ru' => 'Как скорость сайта влияет на продажи',
                    'de' => 'Wie sich die Ladezeit Ihrer Website tatsächlich auf den Umsatz auswirkt',
                    'kk' => 'Сайт жылдамдығы сатылымға қалай әсер етеді?',
                    'uz' => 'Sayt tezligi savdoga qanday taʼsir qiladi?',
                ],
                'excerpt' => [
                    'az' => 'Bir saniyəlik gecikmə neçə müştəri itirir, Core Web Vitals nəyi ölçür və sürəti hansı ardıcıllıqla düzəltmək lazımdır.',
                    'en' => 'What a one-second delay costs you, what Core Web Vitals actually measure, and the order in which to fix speed.',
                    'ru' => 'Сколько клиентов стоит задержка в одну секунду, что измеряют Core Web Vitals и в каком порядке чинить скорость.',
                    'de' => 'Was eine Sekunde Verzögerung kostet, was Core Web Vitals wirklich messen und in welcher Reihenfolge man Geschwindigkeit repariert.',
                    'kk' => 'Бір секундтық кідіріс қанша клиент жоғалтады, Core Web Vitals нені өлшейді және жылдамдықты қандай ретпен түзету керек.',
                    'uz' => 'Bir soniyalik kechikish qancha mijoz yoʻqotadi, Core Web Vitals nimani oʻlchaydi va tezlikni qanday tartibda tuzatish kerak.',
                ],
                'content' => [
                    'az' => <<<'HTML'
<p>Sayt sürəti texniki detal kimi görünür, amma real təsiri satış hesabatında görünür. İstifadəçi səhifənin açılmasını gözləyərkən qərar vermir — sadəcə geri qayıdır. Google-un öz araşdırmaları göstərir ki, mobil səhifənin yüklənməsi 1 saniyədən 3 saniyəyə keçdikdə saytı tərk etmə ehtimalı təxminən 32% artır.</p>
<h2>Core Web Vitals nəyi ölçür?</h2>
<p>Google saytın "sürətini" üç göstərici ilə qiymətləndirir və bu göstəricilər axtarış sıralamasına birbaşa təsir edir:</p>
<ul>
<li><strong>LCP</strong> — ekrandakı ən böyük elementin (adətən başlıq şəkli və ya mətn bloku) görünmə vaxtı. Hədəf: 2,5 saniyədən az.</li>
<li><strong>INP</strong> — istifadəçi klik etdikdən sonra saytın cavab verməsinə qədər keçən vaxt. Hədəf: 200 millisaniyədən az.</li>
<li><strong>CLS</strong> — səhifə yüklənərkən elementlərin "sıçraması". Hədəf: 0,1-dən az.</li>
</ul>
<h2>Hansı ardıcıllıqla düzəltmək lazımdır?</h2>
<p>Praktikada layihələrin böyük hissəsində sürət problemi eyni üç səbəbdən yaranır və düzəliş də eyni ardıcıllıqla ən yaxşı nəticə verir:</p>
<ul>
<li><strong>Şəkillər.</strong> Optimallaşdırılmamış bir başlıq şəkli çox vaxt bütün səhifədən ağır olur. WebP/AVIF formatı, düzgün ölçü və <em>lazy loading</em> tək başına LCP-ni yarıya endirə bilir.</li>
<li><strong>Artıq skriptlər.</strong> Beş fərqli analitika, çat və reklam skripti bir yerdə brauzeri bloklayır. Hər skriptin biznes dəyərini soruşun — cavabı olmayanı silin.</li>
<li><strong>Server cavab müddəti.</strong> Keş qurulmayan sayt hər ziyarətdə eyni hesablamanı təkrarlayır. Server tərəfində keş və CDN bu vaxtı sabit saxlayır.</li>
</ul>
<h2>Ölçmədən başlayın</h2>
<p>Sürəti "hiss" ilə deyil, rəqəmlə idarə edin. PageSpeed Insights laboratoriya nəticəsini, Google Search Console-un Core Web Vitals hesabatı isə real istifadəçi məlumatını göstərir. İkincisi daha vacibdir: real müştəriləriniz sizin inkişaf kompüterinizdən yavaş internetlə girir.</p>
<p>Yeni layihələrdə biz saytı elə texnologiya üzərində qururuq ki, sürət sonradan "düzəldilən" deyil, başlanğıcdan gələn xüsusiyyət olsun — server tərəfində render, avtomatik şəkil optimizasiyası və minimal JavaScript.</p>
HTML,
                    'en' => <<<'HTML'
<p>Site speed looks like a technical detail, but it shows up in the sales report. A visitor waiting for a page to load is not making a decision — they are leaving. Google's own research found that when mobile load time goes from 1 to 3 seconds, the probability of a bounce rises by about 32%.</p>
<h2>What Core Web Vitals measure</h2>
<p>Google grades "speed" with three metrics, and they feed directly into search ranking:</p>
<ul>
<li><strong>LCP</strong> — when the largest element on screen (usually the hero image or headline block) becomes visible. Target: under 2.5 seconds.</li>
<li><strong>INP</strong> — how long the page takes to respond after a user interacts. Target: under 200 milliseconds.</li>
<li><strong>CLS</strong> — how much the layout jumps while loading. Target: under 0.1.</li>
</ul>
<h2>The order to fix things in</h2>
<p>In practice most projects are slow for the same three reasons, and fixing them in this order gives the fastest payoff:</p>
<ul>
<li><strong>Images.</strong> One unoptimised hero image is often heavier than the rest of the page combined. WebP/AVIF, correct dimensions and lazy loading can halve LCP on their own.</li>
<li><strong>Excess scripts.</strong> Five different analytics, chat and ad scripts block the browser together. Ask what business value each one delivers — remove the ones without an answer.</li>
<li><strong>Server response time.</strong> A site with no caching repeats the same work on every visit. Server-side caching and a CDN keep that time flat.</li>
</ul>
<h2>Start by measuring</h2>
<p>Manage speed with numbers, not impressions. PageSpeed Insights gives you the lab result; the Core Web Vitals report in Google Search Console gives you real user data. The second one matters more: your actual customers arrive on slower connections than your development machine.</p>
<p>On new projects we build on a stack where speed is a property of the foundation rather than something patched in later — server-side rendering, automatic image optimisation and minimal JavaScript.</p>
HTML,
                    'ru' => <<<'HTML'
<p>Скорость сайта выглядит технической деталью, но проявляется в отчёте о продажах. Пока пользователь ждёт загрузки, он не принимает решение — он уходит. Исследование Google показало: при росте времени загрузки мобильной страницы с 1 до 3 секунд вероятность отказа увеличивается примерно на 32%.</p>
<h2>Что измеряют Core Web Vitals</h2>
<p>Google оценивает «скорость» тремя метриками, и они напрямую влияют на позиции в поиске:</p>
<ul>
<li><strong>LCP</strong> — момент появления самого крупного элемента экрана (обычно главное изображение или заголовок). Цель: меньше 2,5 секунды.</li>
<li><strong>INP</strong> — время отклика страницы после действия пользователя. Цель: меньше 200 миллисекунд.</li>
<li><strong>CLS</strong> — «прыжки» элементов при загрузке. Цель: меньше 0,1.</li>
</ul>
<h2>В каком порядке чинить</h2>
<p>На практике проекты тормозят по одним и тем же трём причинам, и такой порядок исправлений даёт результат быстрее всего:</p>
<ul>
<li><strong>Изображения.</strong> Одна неоптимизированная картинка в шапке часто весит больше, чем вся остальная страница. WebP/AVIF, правильные размеры и ленивая загрузка сами по себе способны сократить LCP вдвое.</li>
<li><strong>Лишние скрипты.</strong> Пять разных скриптов аналитики, чата и рекламы вместе блокируют браузер. Спросите, какую бизнес-ценность даёт каждый — то, на что нет ответа, удалите.</li>
<li><strong>Время ответа сервера.</strong> Сайт без кеша повторяет одну и ту же работу при каждом визите. Серверный кеш и CDN держат это время стабильным.</li>
</ul>
<h2>Начните с измерения</h2>
<p>Управляйте скоростью цифрами, а не ощущениями. PageSpeed Insights показывает лабораторный результат, отчёт Core Web Vitals в Google Search Console — данные реальных пользователей. Второе важнее: ваши клиенты заходят с более медленным интернетом, чем ваш рабочий компьютер.</p>
<p>В новых проектах мы строим сайт на стеке, где скорость — свойство фундамента, а не заплатка: серверный рендеринг, автоматическая оптимизация изображений и минимум JavaScript.</p>
HTML,
                    'de' => <<<'HTML'
<p>Die Ladezeit sieht wie ein technisches Detail aus, taucht aber im Umsatzbericht auf. Wer auf eine Seite wartet, trifft keine Entscheidung — er geht. Googles eigene Untersuchung zeigt: Steigt die mobile Ladezeit von 1 auf 3 Sekunden, wächst die Absprungwahrscheinlichkeit um etwa 32%.</p>
<h2>Was Core Web Vitals messen</h2>
<p>Google bewertet „Geschwindigkeit“ mit drei Kennzahlen, und sie fließen direkt in das Suchranking ein:</p>
<ul>
<li><strong>LCP</strong> — wann das größte Element auf dem Bildschirm (meist das Hero-Bild oder die Überschrift) sichtbar wird. Ziel: unter 2,5 Sekunden.</li>
<li><strong>INP</strong> — wie lange die Seite braucht, um auf eine Interaktion zu reagieren. Ziel: unter 200 Millisekunden.</li>
<li><strong>CLS</strong> — wie stark das Layout während des Ladens springt. Ziel: unter 0,1.</li>
</ul>
<h2>In welcher Reihenfolge man repariert</h2>
<p>In der Praxis sind die meisten Projekte aus denselben drei Gründen langsam, und diese Reihenfolge zahlt sich am schnellsten aus:</p>
<ul>
<li><strong>Bilder.</strong> Ein einziges unoptimiertes Hero-Bild wiegt oft mehr als die restliche Seite zusammen. WebP/AVIF, korrekte Abmessungen und <em>Lazy Loading</em> können den LCP allein halbieren.</li>
<li><strong>Überflüssige Skripte.</strong> Fünf verschiedene Analyse-, Chat- und Werbeskripte blockieren den Browser gemeinsam. Fragen Sie nach dem geschäftlichen Nutzen jedes einzelnen — entfernen Sie die ohne Antwort.</li>
<li><strong>Server-Antwortzeit.</strong> Eine Seite ohne Caching wiederholt bei jedem Besuch dieselbe Arbeit. Serverseitiges Caching und ein CDN halten diese Zeit konstant.</li>
</ul>
<h2>Beginnen Sie mit dem Messen</h2>
<p>Steuern Sie Geschwindigkeit mit Zahlen, nicht mit Gefühl. PageSpeed Insights liefert das Laborergebnis, der Core-Web-Vitals-Bericht in der Google Search Console die Daten echter Nutzer. Das Zweite wiegt schwerer: Ihre Kunden kommen über langsamere Verbindungen als Ihr Entwicklungsrechner.</p>
<p>Bei neuen Projekten bauen wir auf einem Stack, in dem Geschwindigkeit eine Eigenschaft des Fundaments ist und nicht später aufgesetzt wird — serverseitiges Rendering, automatische Bildoptimierung und minimales JavaScript.</p>
HTML,
                    'kk' => <<<'HTML'
<p>Сайт жылдамдығы техникалық бөлшек сияқты көрінеді, бірақ нақты әсері сату есебінен байқалады. Бет ашылуын күтіп отырған пайдаланушы шешім қабылдамайды — жай ғана кері қайтады. Google-дың өз зерттеуі көрсеткендей, мобильді беттің жүктелуі 1 секундтан 3 секундқа ұзарғанда сайттан кету ықтималдығы шамамен 32% артады.</p>
<h2>Core Web Vitals нені өлшейді?</h2>
<p>Google сайттың «жылдамдығын» үш көрсеткішпен бағалайды және олар іздеу нәтижесіндегі орынға тікелей әсер етеді:</p>
<ul>
<li><strong>LCP</strong> — экрандағы ең үлкен элементтің (әдетте басты сурет немесе мәтін блогы) көріну уақыты. Мақсат: 2,5 секундтан аз.</li>
<li><strong>INP</strong> — пайдаланушы басқаннан кейін сайттың жауап беруіне дейінгі уақыт. Мақсат: 200 миллисекундтан аз.</li>
<li><strong>CLS</strong> — бет жүктелгенде элементтердің «секіруі». Мақсат: 0,1-ден аз.</li>
</ul>
<h2>Қандай ретпен түзету керек?</h2>
<p>Тәжірибеде жобалардың басым бөлігінде жылдамдық мәселесі бірдей үш себептен туындайды және түзетуді дәл осы ретпен жүргізген ең жақсы нәтиже береді:</p>
<ul>
<li><strong>Суреттер.</strong> Оңтайландырылмаған бір басты сурет көбіне бүкіл беттен ауыр болады. WebP/AVIF пішімі, дұрыс өлшем және <em>lazy loading</em> жалғыз өзі LCP-ні екі есе қысқарта алады.</li>
<li><strong>Артық скриптер.</strong> Бес түрлі аналитика, чат және жарнама скриптері бірге браузерді бөгейді. Әр скрипттің бизнеске қандай пайда әкелетінін сұраңыз — жауабы жоғын өшіріңіз.</li>
<li><strong>Сервердің жауап беру уақыты.</strong> Кеші жоқ сайт әр кіргенде сол есептеуді қайталайды. Сервер жағындағы кеш пен CDN бұл уақытты тұрақты ұстайды.</li>
</ul>
<h2>Өлшеуден бастаңыз</h2>
<p>Жылдамдықты «сезіммен» емес, санмен басқарыңыз. PageSpeed Insights зертханалық нәтижені, Google Search Console-дың Core Web Vitals есебі нақты пайдаланушы деректерін көрсетеді. Екіншісі маңыздырақ: нақты клиенттеріңіз сіздің әзірлеу компьютеріңізден баяу интернетпен кіреді.</p>
<p>Жаңа жобаларда сайтты жылдамдық кейін «түзетілетін» емес, бастапқыдан келетін қасиет болатындай технология үстіне құрамыз — сервер жағындағы рендер, автоматты сурет оңтайландыру және ең аз JavaScript.</p>
HTML,
                    'uz' => <<<'HTML'
<p>Sayt tezligi texnik tafsilotdek koʻrinadi, ammo haqiqiy taʼsiri savdo hisobotida namoyon boʻladi. Sahifa ochilishini kutib turgan foydalanuvchi qaror qabul qilmaydi — shunchaki ortga qaytadi. Google’ning oʻz tadqiqoti koʻrsatishicha, mobil sahifaning yuklanishi 1 soniyadan 3 soniyaga oʻtganda saytni tark etish ehtimoli taxminan 32% ortadi.</p>
<h2>Core Web Vitals nimani oʻlchaydi?</h2>
<p>Google saytning «tezligini» uchta koʻrsatkich bilan baholaydi va ular qidiruv natijasidagi oʻringa bevosita taʼsir qiladi:</p>
<ul>
<li><strong>LCP</strong> — ekrandagi eng katta elementning (odatda bosh rasm yoki matn bloki) koʻrinish vaqti. Maqsad: 2,5 soniyadan kam.</li>
<li><strong>INP</strong> — foydalanuvchi bosgandan keyin saytning javob berishigacha oʻtgan vaqt. Maqsad: 200 millisoniyadan kam.</li>
<li><strong>CLS</strong> — sahifa yuklanayotganda elementlarning «sakrashi». Maqsad: 0,1 dan kam.</li>
</ul>
<h2>Qanday tartibda tuzatish kerak?</h2>
<p>Amaliyotda loyihalarning katta qismida tezlik muammosi bir xil uchta sababdan kelib chiqadi va tuzatishni aynan shu tartibda olib borish eng yaxshi natija beradi:</p>
<ul>
<li><strong>Rasmlar.</strong> Optimallashtirilmagan bitta bosh rasm koʻpincha butun sahifadan ogʻirroq boʻladi. WebP/AVIF formati, toʻgʻri oʻlcham va <em>lazy loading</em> yolgʻiz oʻzi LCP’ni ikki barobar qisqartira oladi.</li>
<li><strong>Ortiqcha skriptlar.</strong> Beshta turli analitika, chat va reklama skripti birgalikda brauzerni bloklaydi. Har bir skriptning biznesga qanday foyda berayotganini soʻrang — javobi yoʻgʻini oʻchiring.</li>
<li><strong>Server javob berish vaqti.</strong> Keshi yoʻq sayt har tashrifda oʻsha hisob-kitobni takrorlaydi. Server tomonidagi kesh va CDN bu vaqtni barqaror ushlab turadi.</li>
</ul>
<h2>Oʻlchashdan boshlang</h2>
<p>Tezlikni «his» bilan emas, raqam bilan boshqaring. PageSpeed Insights laboratoriya natijasini, Google Search Console’ning Core Web Vitals hisoboti esa haqiqiy foydalanuvchi maʼlumotini koʻrsatadi. Ikkinchisi muhimroq: haqiqiy mijozlaringiz sizning ishchi kompyuteringizdan sekinroq internet bilan kiradi.</p>
<p>Yangi loyihalarda saytni tezlik keyin «tuzatiladigan» emas, boshidan keladigan xususiyat boʻladigan texnologiya ustiga quramiz — server tomonidagi render, avtomatik rasm optimizatsiyasi va minimal JavaScript.</p>
HTML,
                ],
            ],
            [
                'slug' => 'next-js-yoxsa-wordpress',
                'read_minutes' => 7,
                'published_at' => now()->subDays(14),
                'title' => [
                    'az' => 'Next.js, yoxsa WordPress? Biznes üçün düzgün seçim',
                    'en' => 'Next.js or WordPress? Choosing the right base for your business',
                    'ru' => 'Next.js или WordPress? Как выбрать основу для бизнеса',
                    'de' => 'Next.js oder WordPress? Die richtige Basis für Ihr Unternehmen',
                    'kk' => 'Next.js па, әлде WordPress пе? Бизнес үшін дұрыс таңдау',
                    'uz' => 'Next.js yoki WordPress? Biznes uchun toʻgʻri tanlov',
                ],
                'excerpt' => [
                    'az' => 'İki platformanı reklam şüarları ilə deyil, sahiblik xərci, sürət, təhlükəsizlik və məzmun idarəetməsi baxımından müqayisə edirik.',
                    'en' => 'A comparison based on cost of ownership, speed, security and content management — not marketing slogans.',
                    'ru' => 'Сравнение по стоимости владения, скорости, безопасности и удобству контента — без маркетинговых лозунгов.',
                    'de' => 'Ein Vergleich nach Betriebskosten, Geschwindigkeit, Sicherheit und Redaktionskomfort — ohne Marketingparolen.',
                    'kk' => 'Екі платформаны жарнама ұранымен емес, иелік ету құны, жылдамдық, қауіпсіздік және мазмұнды басқару тұрғысынан салыстырамыз.',
                    'uz' => 'Ikki platformani reklama shiorlari bilan emas, egalik qilish narxi, tezlik, xavfsizlik va kontentni boshqarish nuqtai nazaridan solishtiramiz.',
                ],
                'content' => [
                    'az' => <<<'HTML'
<p>Bu sual demək olar ki, hər ilk görüşdə səslənir. Düzgün cavab "hansı daha yaxşıdır" deyil, "sizin vəziyyətinizdə hansı daha az problem yaradır" sualının cavabıdır.</p>
<h2>WordPress nə vaxt doğru seçimdir?</h2>
<p>Məzmunu tez-tez dəyişən, çoxlu müəllifi olan bloq və xəbər saytları, kiçik büdcə ilə sürətlə başlamaq lazım gələn layihələr — bunlar WordPress-in güclü olduğu ssenarilərdir. Hazır plaginlər sayəsində funksiyanı bir gündə əlavə edə bilirsiniz.</p>
<p>Qiymət isə görünəndən yüksəkdir: hər plagin əlavə yükdür, hər plagin təhlükəsizlik riskidir və hər yeniləmə saytı sındırma ehtimalı ilə gəlir. Beş ildən sonra tipik WordPress saytı 30-40 plaginlə işləyir və heç kim onların yarısının nə üçün quraşdırıldığını xatırlamır.</p>
<h2>Next.js nə vaxt doğru seçimdir?</h2>
<p>Sayt biznesin əsas satış kanalıdırsa, sürət və SEO kritikdirsə, unikal funksiya və ya sistemlərlə inteqrasiya lazımdırsa — Next.js daha sağlam bünövrədir:</p>
<ul>
<li><strong>Sürət.</strong> Səhifələr əvvəlcədən hazırlanır və istifadəçiyə statik fayl kimi çatdırılır; nəticədə Core Web Vitals göstəriciləri təbii olaraq yüksək olur.</li>
<li><strong>Təhlükəsizlik.</strong> Açıq admin girişi və üçüncü tərəf plagin ekosistemi olmadığı üçün hücum səthi kəskin şəkildə azalır.</li>
<li><strong>Nəzarət.</strong> Dizayn və davranış tam sizin nəzarətinizdədir — mövzu şablonunun imkanları ilə məhdudlaşmırsınız.</li>
</ul>
<h2>Bəs məzmunu kim idarə edəcək?</h2>
<p>Ən çox səslənən narahatlıq budur: "Next.js-də mətn dəyişmək üçün proqramçıya müraciət edəcəyəmmi?" Xeyr. Biz belə layihələrdə arxa tərəfdə ayrıca idarəetmə paneli qururuq: mətn, şəkil, xidmət və məqalələr panel üzərindən dəyişir, sayt isə dəyişikliyi avtomatik götürür. Bu, WordPress-in ən yaxşı tərəfini — sərbəst məzmun idarəetməsini — plagin yükü olmadan verir.</p>
<h2>Qısa qayda</h2>
<p>Sayt sizin üçün "onlayn vizit kartı"dırsa və büdcə əsas amildirsə, WordPress kifayət edir. Sayt müştəri gətirən kanaldırsa və növbəti üç ildə inkişaf edəcəksə, fərdi həll uzunmüddətdə həm daha ucuz, həm daha sakit olur.</p>
HTML,
                    'en' => <<<'HTML'
<p>This question comes up in almost every first meeting. The useful answer is not "which one is better", but "which one causes fewer problems in your situation".</p>
<h2>When WordPress is the right call</h2>
<p>Blogs and news sites with frequent updates and many authors, or projects that must launch fast on a small budget — those are scenarios where WordPress is strong. Thanks to ready-made plugins you can add a feature in a day.</p>
<p>The price is higher than it looks, though: every plugin is extra weight, every plugin is a security surface, and every update carries a chance of breaking the site. After five years a typical WordPress install runs 30-40 plugins and nobody remembers why half of them were installed.</p>
<h2>When Next.js is the right call</h2>
<p>If the site is your main sales channel, if speed and SEO are critical, or if you need custom functionality and integrations, Next.js is the sounder foundation:</p>
<ul>
<li><strong>Speed.</strong> Pages are pre-rendered and served as static files, so Core Web Vitals scores are high by default rather than by heroic effort.</li>
<li><strong>Security.</strong> With no public admin login and no third-party plugin ecosystem, the attack surface shrinks dramatically.</li>
<li><strong>Control.</strong> Design and behaviour are entirely yours — you are not limited by what a theme allows.</li>
</ul>
<h2>But who edits the content?</h2>
<p>This is the most common worry: "will I need a developer to change a paragraph?" No. On these projects we build a dedicated admin panel behind the site: text, images, services and articles are edited there, and the site picks up the change automatically. You get the best part of WordPress — self-service content — without the plugin burden.</p>
<h2>The short rule</h2>
<p>If the site is essentially an online business card and budget is the deciding factor, WordPress is enough. If the site is a channel that brings in customers and will keep evolving over the next three years, a custom build is both cheaper and calmer in the long run.</p>
HTML,
                    'ru' => <<<'HTML'
<p>Этот вопрос звучит почти на каждой первой встрече. Полезен не ответ «что лучше», а ответ на вопрос «что создаст меньше проблем именно в вашей ситуации».</p>
<h2>Когда WordPress — правильный выбор</h2>
<p>Блоги и новостные сайты с частыми обновлениями и множеством авторов, проекты, которые нужно запустить быстро и на небольшом бюджете, — здесь WordPress силён. Благодаря готовым плагинам функцию можно добавить за день.</p>
<p>Но цена выше, чем кажется: каждый плагин — это лишний вес, поверхность для атаки и риск, что очередное обновление сломает сайт. Через пять лет типичная установка работает на 30-40 плагинах, и никто уже не помнит, зачем ставили половину из них.</p>
<h2>Когда правильный выбор — Next.js</h2>
<p>Если сайт — основной канал продаж, если критичны скорость и SEO, если нужны нестандартные функции и интеграции, Next.js даёт более крепкий фундамент:</p>
<ul>
<li><strong>Скорость.</strong> Страницы подготавливаются заранее и отдаются как статические файлы, поэтому высокие Core Web Vitals — состояние по умолчанию, а не подвиг.</li>
<li><strong>Безопасность.</strong> Нет публичного входа в админку и экосистемы сторонних плагинов — поверхность атаки резко сокращается.</li>
<li><strong>Контроль.</strong> Дизайн и поведение полностью ваши, вы не ограничены возможностями темы.</li>
</ul>
<h2>А кто будет вести контент?</h2>
<p>Самое частое опасение: «придётся звать разработчика, чтобы поменять абзац?» Нет. В таких проектах мы разворачиваем отдельную панель управления: тексты, изображения, услуги и статьи редактируются в ней, а сайт подхватывает изменения автоматически. Вы получаете лучшую часть WordPress — самостоятельное управление контентом — без плагинной нагрузки.</p>
<h2>Короткое правило</h2>
<p>Если сайт — по сути онлайн-визитка и решающий фактор бюджет, WordPress достаточно. Если сайт приводит клиентов и будет развиваться ближайшие три года, индивидуальное решение в долгую окажется и дешевле, и спокойнее.</p>
HTML,
                    'de' => <<<'HTML'
<p>Diese Frage kommt in fast jedem Erstgespräch. Die nützliche Antwort lautet nicht „was ist besser“, sondern „was macht in Ihrer Situation weniger Probleme“.</p>
<h2>Wann WordPress die richtige Wahl ist</h2>
<p>Blogs und Nachrichtenseiten mit häufigen Updates und vielen Autoren oder Projekte, die mit kleinem Budget schnell starten müssen — dort ist WordPress stark. Dank fertiger Plugins ergänzen Sie eine Funktion an einem Tag.</p>
<p>Der Preis ist allerdings höher, als er aussieht: Jedes Plugin ist zusätzliches Gewicht, jedes Plugin ist eine Sicherheitsfläche, und jedes Update bringt die Chance mit, die Seite zu zerlegen. Nach fünf Jahren läuft eine typische WordPress-Installation mit 30-40 Plugins, und niemand erinnert sich, wofür die Hälfte davon installiert wurde.</p>
<h2>Wann Next.js die richtige Wahl ist</h2>
<p>Wenn die Seite Ihr wichtigster Vertriebskanal ist, wenn Geschwindigkeit und SEO entscheidend sind oder wenn Sie eigene Funktionen und Integrationen brauchen, ist Next.js das solidere Fundament:</p>
<ul>
<li><strong>Geschwindigkeit.</strong> Seiten werden vorab erzeugt und als statische Dateien ausgeliefert; gute Core Web Vitals sind damit der Normalzustand, keine Heldentat.</li>
<li><strong>Sicherheit.</strong> Ohne öffentlichen Admin-Login und ohne Plugin-Ökosystem von Dritten schrumpft die Angriffsfläche drastisch.</li>
<li><strong>Kontrolle.</strong> Design und Verhalten gehören vollständig Ihnen — Sie sind nicht auf das begrenzt, was ein Theme erlaubt.</li>
</ul>
<h2>Wer pflegt dann die Inhalte?</h2>
<p>Das ist die häufigste Sorge: „Brauche ich einen Entwickler, um einen Absatz zu ändern?“ Nein. In solchen Projekten bauen wir hinter der Seite ein eigenes Admin-Panel: Texte, Bilder, Leistungen und Artikel werden dort bearbeitet, und die Seite übernimmt die Änderung automatisch. Sie bekommen den besten Teil von WordPress — selbstständige Inhaltspflege — ohne die Plugin-Last.</p>
<h2>Die kurze Regel</h2>
<p>Ist die Seite im Kern eine Online-Visitenkarte und das Budget der entscheidende Faktor, reicht WordPress. Bringt die Seite Kunden und wächst sie über die nächsten drei Jahre weiter, ist eine individuelle Lösung auf lange Sicht sowohl günstiger als auch ruhiger.</p>
HTML,
                    'kk' => <<<'HTML'
<p>Бұл сұрақ кез келген алғашқы кездесуде дерлік қойылады. Дұрыс жауап «қайсысы жақсы» емес, «сіздің жағдайыңызда қайсысы аз мәселе тудырады» деген сұрақтың жауабы.</p>
<h2>WordPress қашан дұрыс таңдау?</h2>
<p>Мазмұны жиі өзгеретін, авторы көп блог және жаңалық сайттары, шағын бюджетпен тез бастау керек жобалар — бұлар WordPress мықты болатын сценарийлер. Дайын плагиндер арқасында функцияны бір күнде қосуға болады.</p>
<p>Бағасы көрінгеннен жоғары: әр плагин қосымша салмақ, әр плагин қауіпсіздік тәуекелі және әр жаңарту сайтты бұзу ықтималдығымен келеді. Бес жылдан кейін әдеттегі WordPress сайты 30-40 плагинмен жұмыс істейді және олардың жартысы не үшін орнатылғанын ешкім есіне түсіре алмайды.</p>
<h2>Next.js қашан дұрыс таңдау?</h2>
<p>Сайт бизнестің негізгі сату арнасы болса, жылдамдық пен SEO шешуші болса, ерекше функция немесе жүйелермен интеграция қажет болса — Next.js берік іргетас:</p>
<ul>
<li><strong>Жылдамдық.</strong> Беттер алдын ала дайындалып, пайдаланушыға статикалық файл ретінде жеткізіледі; нәтижесінде Core Web Vitals көрсеткіштері табиғи түрде жоғары болады.</li>
<li><strong>Қауіпсіздік.</strong> Ашық админ кірісі мен үшінші тарап плагин экожүйесі болмағандықтан шабуыл ауқымы күрт азаяды.</li>
<li><strong>Бақылау.</strong> Дизайн мен мінез-құлық толықтай сіздің бақылауыңызда — тема шаблонының мүмкіндіктерімен шектелмейсіз.</li>
</ul>
<h2>Ал мазмұнды кім басқарады?</h2>
<p>Ең жиі айтылатын алаңдаушылық осы: «Next.js-те мәтін өзгерту үшін бағдарламашыға жүгінемін бе?» Жоқ. Мұндай жобаларда сайттың артында бөлек басқару панелін құрамыз: мәтін, сурет, қызмет және мақалалар панель арқылы өзгертіледі, сайт өзгерісті автоматты түрде қабылдайды. Бұл WordPress-тің ең жақсы жағын — еркін мазмұн басқаруды — плагин жүктемесінсіз береді.</p>
<h2>Қысқаша ереже</h2>
<p>Сайт сіз үшін «онлайн визит карта» болса және бюджет басты фактор болса, WordPress жеткілікті. Сайт клиент әкелетін арна болса және алдағы үш жылда дамитын болса, жеке шешім ұзақ мерзімде әрі арзан, әрі тыныш болады.</p>
HTML,
                    'uz' => <<<'HTML'
<p>Bu savol deyarli har bir birinchi uchrashuvda yangraydi. Toʻgʻri javob «qaysi biri yaxshiroq» emas, «sizning holatingizda qaysi biri kamroq muammo tugʻdiradi» degan savolning javobidir.</p>
<h2>WordPress qachon toʻgʻri tanlov?</h2>
<p>Mazmuni tez-tez oʻzgaradigan, mualliflari koʻp blog va yangiliklar saytlari, kichik byudjet bilan tez boshlash kerak boʻlgan loyihalar — bular WordPress kuchli boʻlgan ssenariylar. Tayyor plaginlar tufayli funksiyani bir kunda qoʻshish mumkin.</p>
<p>Narxi esa koʻringanidan yuqori: har bir plagin qoʻshimcha yuk, har bir plagin xavfsizlik xatari va har bir yangilanish saytni buzish ehtimoli bilan keladi. Besh yildan keyin odatiy WordPress sayti 30-40 plagin bilan ishlaydi va ularning yarmi nima uchun oʻrnatilganini hech kim eslay olmaydi.</p>
<h2>Next.js qachon toʻgʻri tanlov?</h2>
<p>Sayt biznesning asosiy savdo kanali boʻlsa, tezlik va SEO hal qiluvchi boʻlsa, oʻziga xos funksiya yoki tizimlar bilan integratsiya kerak boʻlsa — Next.js mustahkamroq poydevor:</p>
<ul>
<li><strong>Tezlik.</strong> Sahifalar oldindan tayyorlanadi va foydalanuvchiga statik fayl sifatida yetkaziladi; natijada Core Web Vitals koʻrsatkichlari tabiiy ravishda yuqori boʻladi.</li>
<li><strong>Xavfsizlik.</strong> Ochiq admin kirishi va uchinchi tomon plagin ekotizimi boʻlmagani uchun hujum yuzasi keskin qisqaradi.</li>
<li><strong>Nazorat.</strong> Dizayn va xatti-harakat toʻliq sizning nazoratingizda — mavzu shabloni imkoniyatlari bilan cheklanmaysiz.</li>
</ul>
<h2>Xoʻsh, mazmunni kim boshqaradi?</h2>
<p>Eng koʻp uchraydigan xavotir shu: «Next.js’da matn oʻzgartirish uchun dasturchiga murojaat qilamanmi?» Yoʻq. Bunday loyihalarda saytning orqasida alohida boshqaruv panelini quramiz: matn, rasm, xizmat va maqolalar panel orqali oʻzgartiriladi, sayt esa oʻzgarishni avtomatik qabul qiladi. Bu WordPress’ning eng yaxshi tomonini — mustaqil kontent boshqaruvini — plagin yukisiz beradi.</p>
<h2>Qisqa qoida</h2>
<p>Sayt siz uchun «onlayn tashrifnoma» boʻlsa va byudjet asosiy omil boʻlsa, WordPress yetarli. Sayt mijoz keltiradigan kanal boʻlsa va keyingi uch yilda rivojlanadigan boʻlsa, individual yechim uzoq muddatda ham arzonroq, ham tinchroq boʻladi.</p>
HTML,
                ],
            ],
            [
                'slug' => 'texniki-seo-audit-yoxlama-siyahisi',
                'read_minutes' => 8,
                'published_at' => now()->subDays(24),
                'title' => [
                    'az' => 'Texniki SEO auditi: 8 addımlıq yoxlama siyahısı',
                    'en' => 'Technical SEO audit: an 8-step checklist',
                    'ru' => 'Технический SEO-аудит: чек-лист из 8 шагов',
                    'de' => 'Technisches SEO-Audit: eine Checkliste in 8 Schritten',
                    'kk' => 'Техникалық SEO аудиті: 8 қадамдық тексеру тізімі',
                    'uz' => 'Texnik SEO auditi: 8 qadamli tekshiruv roʻyxati',
                ],
                'excerpt' => [
                    'az' => 'Məzmun yazmadan əvvəl saytın texniki bazasını yoxlayın: indeksləşmə, struktur, sürət və strukturlaşdırılmış məlumat.',
                    'en' => 'Before writing more content, check the technical base: indexing, structure, speed and structured data.',
                    'ru' => 'Прежде чем писать контент, проверьте техническую базу: индексацию, структуру, скорость и разметку.',
                    'de' => 'Bevor Sie weiteren Inhalt schreiben, prüfen Sie die technische Basis: Indexierung, Struktur, Geschwindigkeit und strukturierte Daten.',
                    'kk' => 'Мазмұн жазбас бұрын сайттың техникалық негізін тексеріңіз: индекстелу, құрылым, жылдамдық және құрылымдалған дерек.',
                    'uz' => 'Kontent yozishdan oldin saytning texnik asosini tekshiring: indekslanish, tuzilma, tezlik va tuzilmali maʼlumot.',
                ],
                'content' => [
                    'az' => <<<'HTML'
<p>Texniki SEO sıralamanı təkbaşına qaldırmır, amma texniki problemi olan sayt nə qədər yaxşı məzmun yazsa da, tavana çatır. Aşağıdakı siyahını hər audit başlanğıcında keçiririk.</p>
<h2>1. İndeksləşmə</h2>
<p><code>site:domen.az</code> sorğusu ilə axtarış sistemində neçə səhifənizin olduğunu yoxlayın. Rəqəm gözlədiyinizdən çox aşağıdırsa — indeksləşmə problemi var; həddindən artıq çoxdursa — təkrar və zibil səhifələr indeksə düşüb.</p>
<h2>2. robots.txt və sitemap.xml</h2>
<p>robots.txt təsadüfən vacib bölmələri bağlamamalıdır. Sitemap yalnız kanonik, 200 cavab verən səhifələri saxlamalı və Search Console-a təqdim olunmalıdır.</p>
<h2>3. Kanonik ünvanlar</h2>
<p>Eyni məzmuna aparan bir neçə ünvan (www/qeyri-www, http/https, sonda kəsik işarəsi, filtr parametrləri) axtarış sisteminin gücünü bölür. Hər səhifənin bir kanonik ünvanı olmalı, qalanları ona 301 ilə yönlənməlidir.</p>
<h2>4. Başlıq strukturu</h2>
<p>Hər səhifədə bir H1, ardıcıl H2/H3 iyerarxiyası. Başlıqlar dizayn elementi deyil, məzmunun planıdır — həm axtarış sistemi, həm ekran oxuyucusu onunla naviqasiya edir.</p>
<h2>5. Meta məlumatlar</h2>
<p>Title 50-60 simvol, description 140-160 simvol və hər səhifə üçün unikal olmalıdır. Şablondan avtomatik yaranan eyni mətnlər klik nisbətini aşağı salır.</p>
<h2>6. Sürət və mobil uyğunluq</h2>
<p>Core Web Vitals hesabatını real istifadəçi məlumatı üzərində yoxlayın. Trafikin böyük hissəsi mobildən gəlirsə, audit də mobil versiyadan başlamalıdır.</p>
<h2>7. Strukturlaşdırılmış məlumat</h2>
<p>Organization, Breadcrumb, Article, FAQ və Service sxemləri axtarış nəticəsində əlavə görünüş qazandırır. Bu gün eyni zamanda süni intellekt əsaslı axtarış sistemlərinin saytı düzgün başa düşməsi üçün də əsas mənbədir.</p>
<h2>8. Daxili keçidlər</h2>
<p>Vacib səhifə ana səhifədən üç klikdən uzaqdırsa, həm istifadəçi, həm axtarış robotu onu çətin tapır. Mövzu ilə bağlı səhifələri bir-birinə mənalı mətnlə bağlayın.</p>
<p>Siyahını bir dəfə keçmək kifayət deyil — sayt dəyişdikcə eyni problemlər qayıdır. Rüblük təkrar audit bunun qarşısını alır.</p>
HTML,
                    'en' => <<<'HTML'
<p>Technical SEO does not lift rankings on its own, but a site with technical problems hits a ceiling no matter how good the content is. We run this checklist at the start of every audit.</p>
<h2>1. Indexing</h2>
<p>Search <code>site:yourdomain.com</code> to see how many of your pages are in the index. Far fewer than expected means an indexing problem; far more means duplicates and junk pages made it in.</p>
<h2>2. robots.txt and sitemap.xml</h2>
<p>robots.txt must not accidentally block important sections. The sitemap should list only canonical pages that return 200, and it should be submitted in Search Console.</p>
<h2>3. Canonical URLs</h2>
<p>Several URLs leading to the same content (www/non-www, http/https, trailing slash, filter parameters) split your ranking signals. Every page needs one canonical URL, with the rest 301-redirected to it.</p>
<h2>4. Heading structure</h2>
<p>One H1 per page and a consistent H2/H3 hierarchy. Headings are not a design element — they are the outline of the content, and both crawlers and screen readers navigate by them.</p>
<h2>5. Metadata</h2>
<p>Titles of 50-60 characters, descriptions of 140-160, unique on every page. Auto-generated identical text lowers click-through rate.</p>
<h2>6. Speed and mobile</h2>
<p>Check the Core Web Vitals report on real user data. If most of your traffic is mobile, the audit should start with the mobile version.</p>
<h2>7. Structured data</h2>
<p>Organization, Breadcrumb, Article, FAQ and Service schemas earn richer search results. They are also the main way AI-driven search engines understand what your site is about.</p>
<h2>8. Internal links</h2>
<p>If an important page is more than three clicks from the homepage, both users and crawlers struggle to find it. Link related pages to each other with meaningful anchor text.</p>
<p>Running the list once is not enough — as the site changes the same problems come back. A quarterly re-audit keeps them out.</p>
HTML,
                    'ru' => <<<'HTML'
<p>Технический SEO сам по себе не поднимает позиции, но сайт с техническими проблемами упирается в потолок, каким бы хорошим ни был контент. Этот чек-лист мы проходим в начале каждого аудита.</p>
<h2>1. Индексация</h2>
<p>Запрос <code>site:вашдомен.az</code> покажет, сколько страниц в индексе. Существенно меньше ожидаемого — проблема с индексацией; значительно больше — в индекс попали дубли и мусорные страницы.</p>
<h2>2. robots.txt и sitemap.xml</h2>
<p>robots.txt не должен случайно закрывать важные разделы. В карте сайта — только канонические страницы, отдающие 200, и она должна быть добавлена в Search Console.</p>
<h2>3. Канонические адреса</h2>
<p>Несколько адресов с одним содержимым (www/без www, http/https, слеш в конце, параметры фильтров) размывают сигналы. У каждой страницы должен быть один канонический URL, остальные — 301-редиректом на него.</p>
<h2>4. Структура заголовков</h2>
<p>Один H1 на страницу и последовательная иерархия H2/H3. Заголовки — не элемент дизайна, а план контента: по ним ориентируются и роботы, и программы чтения с экрана.</p>
<h2>5. Метаданные</h2>
<p>Title 50-60 символов, description 140-160, уникальные для каждой страницы. Одинаковый шаблонный текст снижает кликабельность.</p>
<h2>6. Скорость и мобильная версия</h2>
<p>Смотрите отчёт Core Web Vitals по данным реальных пользователей. Если основной трафик мобильный, аудит начинается с мобильной версии.</p>
<h2>7. Микроразметка</h2>
<p>Схемы Organization, Breadcrumb, Article, FAQ и Service дают расширенные результаты в выдаче. Сегодня это ещё и основной способ, которым ИИ-поисковики понимают, о чём ваш сайт.</p>
<h2>8. Внутренние ссылки</h2>
<p>Если важная страница дальше трёх кликов от главной, её тяжело найти и пользователю, и роботу. Связывайте тематически близкие страницы осмысленными ссылками.</p>
<p>Пройти список один раз недостаточно — вместе с изменениями сайта проблемы возвращаются. Ежеквартальный повторный аудит их не пускает.</p>
HTML,
                    'de' => <<<'HTML'
<p>Technisches SEO hebt Rankings nicht allein, aber eine Seite mit technischen Problemen stößt an eine Decke, so gut der Inhalt auch sein mag. Diese Liste gehen wir zu Beginn jedes Audits durch.</p>
<h2>1. Indexierung</h2>
<p>Suchen Sie nach <code>site:ihredomain.de</code>, um zu sehen, wie viele Ihrer Seiten im Index stehen. Deutlich weniger als erwartet heißt Indexierungsproblem; deutlich mehr heißt, dass Duplikate und Müllseiten hineingeraten sind.</p>
<h2>2. robots.txt und sitemap.xml</h2>
<p>Die robots.txt darf wichtige Bereiche nicht versehentlich sperren. Die Sitemap sollte nur kanonische Seiten mit Status 200 enthalten und in der Search Console eingereicht sein.</p>
<h2>3. Kanonische URLs</h2>
<p>Mehrere URLs mit demselben Inhalt (www/ohne www, http/https, abschließender Schrägstrich, Filterparameter) verteilen Ihre Ranking-Signale. Jede Seite braucht eine kanonische URL, alle übrigen werden per 301 dorthin geleitet.</p>
<h2>4. Überschriftenstruktur</h2>
<p>Eine H1 pro Seite und eine konsistente H2/H3-Hierarchie. Überschriften sind kein Designelement — sie sind die Gliederung des Inhalts, und sowohl Crawler als auch Screenreader navigieren daran entlang.</p>
<h2>5. Metadaten</h2>
<p>Title mit 50-60 Zeichen, Description mit 140-160, auf jeder Seite einzigartig. Automatisch erzeugte, identische Texte senken die Klickrate.</p>
<h2>6. Geschwindigkeit und Mobilgeräte</h2>
<p>Prüfen Sie den Core-Web-Vitals-Bericht anhand echter Nutzerdaten. Kommt der Großteil Ihres Traffics vom Handy, beginnt das Audit bei der mobilen Version.</p>
<h2>7. Strukturierte Daten</h2>
<p>Die Schemata Organization, Breadcrumb, Article, FAQ und Service bringen reichhaltigere Suchergebnisse. Zugleich sind sie heute die wichtigste Quelle dafür, dass KI-gestützte Suchsysteme Ihre Seite richtig verstehen.</p>
<h2>8. Interne Verlinkung</h2>
<p>Ist eine wichtige Seite mehr als drei Klicks von der Startseite entfernt, finden sie weder Nutzer noch Crawler leicht. Verlinken Sie thematisch verwandte Seiten mit aussagekräftigem Ankertext.</p>
<p>Die Liste einmal durchzugehen reicht nicht — mit jeder Änderung der Seite kommen dieselben Probleme zurück. Ein Re-Audit pro Quartal hält sie draußen.</p>
HTML,
                    'kk' => <<<'HTML'
<p>Техникалық SEO рейтингті жалғыз өзі көтермейді, бірақ техникалық ақауы бар сайт мазмұны қаншалықты жақсы болса да, төбеге тіреледі. Төмендегі тізімді әр аудиттің басында қараймыз.</p>
<h2>1. Индекстелу</h2>
<p><code>site:домен.kz</code> сұрауымен іздеу жүйесінде неше бетіңіз бар екенін тексеріңіз. Сан күткеніңізден әлдеқайда аз болса — индекстелу мәселесі бар; тым көп болса — қайталанатын және қоқыс беттер индекске түскен.</p>
<h2>2. robots.txt және sitemap.xml</h2>
<p>robots.txt кездейсоқ маңызды бөлімдерді жаппауы керек. Sitemap тек канондық, 200 жауап беретін беттерді сақтап, Search Console-ға ұсынылуы тиіс.</p>
<h2>3. Канондық мекенжайлар</h2>
<p>Бір мазмұнға апаратын бірнеше мекенжай (www/www-сіз, http/https, соңындағы қиғаш сызық, сүзгі параметрлері) іздеу жүйесінің күшін бөледі. Әр беттің бір канондық мекенжайы болып, қалғандары оған 301-мен бағытталуы керек.</p>
<h2>4. Тақырып құрылымы</h2>
<p>Әр бетте бір H1, дәйекті H2/H3 иерархиясы. Тақырыптар дизайн элементі емес, мазмұнның жоспары — іздеу жүйесі де, экран оқығышы да сол арқылы бағдарланады.</p>
<h2>5. Метадеректер</h2>
<p>Title 50-60 таңба, description 140-160 таңба және әр бет үшін бірегей болуы керек. Шаблоннан автоматты пайда болатын бірдей мәтіндер басу үлесін төмендетеді.</p>
<h2>6. Жылдамдық және мобильді сәйкестік</h2>
<p>Core Web Vitals есебін нақты пайдаланушы деректері бойынша тексеріңіз. Трафиктің басым бөлігі мобильден келсе, аудит те мобильді нұсқадан басталуы тиіс.</p>
<h2>7. Құрылымдалған дерек</h2>
<p>Organization, Breadcrumb, Article, FAQ және Service схемалары іздеу нәтижесінде қосымша көрініс береді. Бүгінде бұл сонымен қатар жасанды интеллектке негізделген іздеу жүйелерінің сайтты дұрыс түсінуі үшін де негізгі дереккөз.</p>
<h2>8. Ішкі сілтемелер</h2>
<p>Маңызды бет басты беттен үш басудан алыс болса, оны пайдаланушы да, іздеу роботы да қиын табады. Тақырыбы жақын беттерді бір-бірімен мағыналы мәтінмен байланыстырыңыз.</p>
<p>Тізімді бір рет қарау жеткіліксіз — сайт өзгерген сайын сол мәселелер қайтады. Тоқсан сайынғы қайталама аудит оның алдын алады.</p>
HTML,
                    'uz' => <<<'HTML'
<p>Texnik SEO reytingni yolgʻiz oʻzi koʻtarmaydi, ammo texnik muammosi bor sayt kontenti qanchalik yaxshi boʻlmasin, shiftga tiraladi. Quyidagi roʻyxatni har bir audit boshida koʻrib chiqamiz.</p>
<h2>1. Indekslanish</h2>
<p><code>site:domeningiz.uz</code> soʻrovi bilan qidiruv tizimida nechta sahifangiz borligini tekshiring. Raqam kutganingizdan ancha kam boʻlsa — indekslanish muammosi bor; haddan tashqari koʻp boʻlsa — takroriy va keraksiz sahifalar indeksga tushgan.</p>
<h2>2. robots.txt va sitemap.xml</h2>
<p>robots.txt tasodifan muhim boʻlimlarni yopib qoʻymasligi kerak. Sitemap faqat kanonik, 200 javob qaytaradigan sahifalarni saqlashi va Search Console’ga taqdim etilishi lozim.</p>
<h2>3. Kanonik manzillar</h2>
<p>Bir mazmunga olib boradigan bir nechta manzil (www/www’siz, http/https, oxiridagi qiya chiziq, filtr parametrlari) qidiruv tizimining kuchini boʻlib yuboradi. Har bir sahifaning bitta kanonik manzili boʻlib, qolganlari unga 301 bilan yoʻnaltirilishi kerak.</p>
<h2>4. Sarlavha tuzilmasi</h2>
<p>Har bir sahifada bitta H1, izchil H2/H3 iyerarxiyasi. Sarlavhalar dizayn elementi emas, kontentning rejasi — qidiruv tizimi ham, ekran oʻqigich ham shu orqali yoʻl topadi.</p>
<h2>5. Metamaʼlumotlar</h2>
<p>Title 50-60 belgi, description 140-160 belgi va har bir sahifa uchun noyob boʻlishi kerak. Shablondan avtomatik hosil boʻladigan bir xil matnlar bosish ulushini pasaytiradi.</p>
<h2>6. Tezlik va mobil moslik</h2>
<p>Core Web Vitals hisobotini haqiqiy foydalanuvchi maʼlumotlari boʻyicha tekshiring. Trafikning katta qismi mobildan kelsa, audit ham mobil versiyadan boshlanishi kerak.</p>
<h2>7. Tuzilmali maʼlumot</h2>
<p>Organization, Breadcrumb, Article, FAQ va Service sxemalari qidiruv natijasida qoʻshimcha koʻrinish beradi. Bugun bu ayni paytda sunʼiy intellektga asoslangan qidiruv tizimlarining saytni toʻgʻri tushunishi uchun ham asosiy manba.</p>
<h2>8. Ichki havolalar</h2>
<p>Muhim sahifa bosh sahifadan uch bosishdan uzoq boʻlsa, uni foydalanuvchi ham, qidiruv roboti ham qiyin topadi. Mavzusi yaqin sahifalarni bir-biriga mazmunli matn bilan bogʻlang.</p>
<p>Roʻyxatni bir marta koʻrib chiqish yetarli emas — sayt oʻzgargan sayin oʻsha muammolar qaytadi. Choraklik takroriy audit buning oldini oladi.</p>
HTML,
                ],
            ],
            [
                'slug' => 'geo-ai-axtarisinda-gorunmek',
                'read_minutes' => 5,
                'published_at' => now()->subDays(33),
                'title' => [
                    'az' => 'GEO: brendinizi AI axtarışında necə göstərmək olar?',
                    'en' => 'GEO: how to make your brand visible in AI search',
                    'ru' => 'GEO: как сделать бренд заметным в AI-поиске',
                    'de' => 'GEO: Wie Ihre Marke in der KI-Suche sichtbar wird',
                    'kk' => 'GEO: брендіңізді ЖИ іздеуінде қалай көрсетуге болады?',
                    'uz' => 'GEO: brendingizni SI qidiruvida qanday koʻrsatish mumkin?',
                ],
                'excerpt' => [
                    'az' => 'İstifadəçilər artıq suallarını çat botlarına verir. Cavabda sizin adınızın çəkilməsi üçün saytın nəyə ehtiyacı var?',
                    'en' => 'People increasingly ask chatbots instead of search engines. What does your site need for your name to appear in the answer?',
                    'ru' => 'Пользователи всё чаще спрашивают чат-ботов, а не поисковик. Что нужно сайту, чтобы прозвучало ваше имя?',
                    'de' => 'Menschen fragen zunehmend Chatbots statt Suchmaschinen. Was braucht Ihre Seite, damit Ihr Name in der Antwort auftaucht?',
                    'kk' => 'Пайдаланушылар сұрақтарын енді чат-боттарға қояды. Жауапта сіздің атыңыз аталуы үшін сайтқа не қажет?',
                    'uz' => 'Foydalanuvchilar savollarini endi chat-botlarga beradi. Javobda sizning nomingiz aytilishi uchun saytga nima kerak?',
                ],
                'content' => [
                    'az' => <<<'HTML'
<p>Klassik SEO sizi nəticələr siyahısına çıxarır. GEO (Generative Engine Optimization) isə fərqli sualın cavabıdır: istifadəçi ChatGPT, Perplexity və ya Google-un AI cavabından "Bakıda etibarlı veb studiya" soruşduqda cavabın içində sizin adınız keçirmi?</p>
<h2>AI cavabı necə qurur?</h2>
<p>Modellər cavabı sizin saytınızın dizaynına baxaraq deyil, mətni oxuyaraq və başqa mənbələrdəki qeydlərlə tutuşduraraq qurur. Buna görə GEO-nun əsasında üç şey dayanır: aydın mətn, maşının oxuya biləcəyi struktur və xarici təsdiq.</p>
<h2>Praktikada nə etmək lazımdır?</h2>
<ul>
<li><strong>Sual-cavab formatı.</strong> Real müştəri suallarını başlıq kimi yazın və birbaşa altında qısa, dəqiq cavab verin. Modellər məhz belə blokları sitat gətirir.</li>
<li><strong>Faktları mətnə yazın.</strong> Qiymət aralığı, müddət, əhatə etdiyiniz şəhər, texnologiya adları — bunlar şəkil içində deyil, mətndə olmalıdır.</li>
<li><strong>Strukturlaşdırılmış məlumat.</strong> Organization, FAQPage, Service və Article sxemləri saytın nə haqqında olduğunu birmənalı bildirir.</li>
<li><strong>robots.txt-də AI robotlarına münasibət.</strong> GPTBot, ClaudeBot, PerplexityBot kimi robotları bilərəkdən bağlamısınızsa, cavabda görünməyiniz mümkün deyil.</li>
<li><strong>Xarici izlər.</strong> Kataloqlar, mətbuat, peşəkar platformalar və müştəri rəyləri modelin sizi "real şirkət" kimi tanımasına kömək edir.</li>
</ul>
<h2>Ölçmək mümkündürmü?</h2>
<p>Hələ ki klassik sıralama hesabatı qədər dəqiq deyil, amma sadə üsul işləyir: özünüzün və rəqiblərinizin adı ilə bağlı 15-20 tipik sualı seçib hər ay eyni çat modellərində yoxlayın və cavabda kimin adının keçdiyini qeyd edin. Bu, GEO işinin istiqamətini göstərmək üçün kifayət edir.</p>
<p>Yaxşı xəbər budur ki, GEO klassik SEO-nu əvəz etmir — eyni təməl üzərində qurulur. Texniki bazası düzgün olan sayt bu yeni kanalda da avtomatik olaraq irəlidədir.</p>
HTML,
                    'en' => <<<'HTML'
<p>Classic SEO gets you into the list of results. GEO (Generative Engine Optimization) answers a different question: when someone asks ChatGPT, Perplexity or Google's AI answer for "a reliable web studio in Baku", does your name appear inside the answer?</p>
<h2>How an AI builds its answer</h2>
<p>Models do not look at your design; they read your text and cross-check it against mentions elsewhere. GEO therefore rests on three things: clear writing, machine-readable structure and external confirmation.</p>
<h2>What to do in practice</h2>
<ul>
<li><strong>Question-and-answer format.</strong> Turn real customer questions into headings and answer them directly underneath, briefly and precisely. Those are exactly the blocks models quote.</li>
<li><strong>Put facts in the text.</strong> Price ranges, timelines, the cities you serve, the technologies you use — these belong in text, not inside an image.</li>
<li><strong>Structured data.</strong> Organization, FAQPage, Service and Article schemas state unambiguously what the site is about.</li>
<li><strong>AI crawlers in robots.txt.</strong> If you have deliberately blocked GPTBot, ClaudeBot or PerplexityBot, appearing in their answers is simply not possible.</li>
<li><strong>External footprint.</strong> Directories, press, professional platforms and customer reviews help a model recognise you as a real company.</li>
</ul>
<h2>Can it be measured?</h2>
<p>Not as precisely as a rank tracker yet, but a simple method works: pick 15-20 typical questions around your and your competitors' names, ask the same chat models every month, and record whose name shows up. That is enough to steer the work.</p>
<p>The good news is that GEO does not replace classic SEO — it stands on the same foundation. A site with a solid technical base is already ahead in this new channel.</p>
HTML,
                    'ru' => <<<'HTML'
<p>Классическое SEO выводит вас в список результатов. GEO (Generative Engine Optimization) отвечает на другой вопрос: когда человек спрашивает у ChatGPT, Perplexity или AI-ответа Google «надёжная веб-студия в Баку», звучит ли в ответе ваше имя?</p>
<h2>Как ИИ строит ответ</h2>
<p>Модели не смотрят на ваш дизайн — они читают текст и сверяют его с упоминаниями в других источниках. Поэтому GEO держится на трёх вещах: понятный текст, машиночитаемая структура и внешнее подтверждение.</p>
<h2>Что делать на практике</h2>
<ul>
<li><strong>Формат «вопрос — ответ».</strong> Превратите реальные вопросы клиентов в заголовки и дайте под ними короткий точный ответ. Именно такие блоки модели цитируют.</li>
<li><strong>Факты — в текст.</strong> Диапазон цен, сроки, города обслуживания, названия технологий должны быть текстом, а не картинкой.</li>
<li><strong>Микроразметка.</strong> Схемы Organization, FAQPage, Service и Article однозначно объясняют, о чём сайт.</li>
<li><strong>AI-роботы в robots.txt.</strong> Если вы намеренно закрыли GPTBot, ClaudeBot или PerplexityBot, попасть в их ответы невозможно.</li>
<li><strong>Внешний след.</strong> Каталоги, пресса, профессиональные площадки и отзывы клиентов помогают модели распознать в вас реальную компанию.</li>
</ul>
<h2>Можно ли это измерить?</h2>
<p>Пока не так точно, как позиции в выдаче, но работает простой метод: возьмите 15-20 типичных вопросов вокруг вашего имени и имён конкурентов, ежемесячно задавайте их одним и тем же моделям и фиксируйте, чьё название звучит. Этого достаточно, чтобы задать направление работы.</p>
<p>Хорошая новость: GEO не заменяет классическое SEO, а стоит на том же фундаменте. Сайт с крепкой технической базой уже впереди и в этом новом канале.</p>
HTML,
                    'de' => <<<'HTML'
<p>Klassisches SEO bringt Sie in die Ergebnisliste. GEO (Generative Engine Optimization) beantwortet eine andere Frage: Wenn jemand ChatGPT, Perplexity oder die KI-Antwort von Google nach „einer zuverlässigen Webagentur in Baku“ fragt, steht Ihr Name dann in der Antwort?</p>
<h2>Wie eine KI ihre Antwort baut</h2>
<p>Modelle schauen nicht auf Ihr Design; sie lesen Ihren Text und gleichen ihn mit Erwähnungen an anderer Stelle ab. GEO ruht deshalb auf drei Dingen: klarer Sprache, maschinenlesbarer Struktur und externer Bestätigung.</p>
<h2>Was in der Praxis zu tun ist</h2>
<ul>
<li><strong>Frage-Antwort-Format.</strong> Machen Sie echte Kundenfragen zu Überschriften und beantworten Sie sie direkt darunter, kurz und präzise. Genau solche Blöcke zitieren die Modelle.</li>
<li><strong>Fakten in den Text.</strong> Preisspannen, Zeiträume, die Städte, die Sie bedienen, eingesetzte Technologien — das gehört in den Text, nicht in ein Bild.</li>
<li><strong>Strukturierte Daten.</strong> Die Schemata Organization, FAQPage, Service und Article sagen eindeutig, worum es auf der Seite geht.</li>
<li><strong>KI-Crawler in der robots.txt.</strong> Wenn Sie GPTBot, ClaudeBot oder PerplexityBot bewusst gesperrt haben, ist ein Auftritt in deren Antworten schlicht nicht möglich.</li>
<li><strong>Externe Spuren.</strong> Verzeichnisse, Presse, Fachplattformen und Kundenbewertungen helfen einem Modell, Sie als echtes Unternehmen zu erkennen.</li>
</ul>
<h2>Lässt sich das messen?</h2>
<p>Noch nicht so genau wie ein Rank-Tracker, aber eine einfache Methode funktioniert: Wählen Sie 15-20 typische Fragen rund um Ihren Namen und den Ihrer Wettbewerber, stellen Sie sie monatlich denselben Chatmodellen und notieren Sie, wessen Name erscheint. Das genügt, um die Arbeit zu steuern.</p>
<p>Die gute Nachricht: GEO ersetzt klassisches SEO nicht — es steht auf demselben Fundament. Eine Seite mit solider technischer Basis liegt in diesem neuen Kanal automatisch vorn.</p>
HTML,
                    'kk' => <<<'HTML'
<p>Классикалық SEO сізді нәтижелер тізіміне шығарады. GEO (Generative Engine Optimization) басқа сұрақтың жауабы: пайдаланушы ChatGPT, Perplexity немесе Google-дың ЖИ жауабынан «Бакудегі сенімді веб-студия» деп сұрағанда, жауаптың ішінде сіздің атыңыз аталады ма?</p>
<h2>ЖИ жауабын қалай құрады?</h2>
<p>Модельдер жауапты сіздің сайтыңыздың дизайнына қарап емес, мәтінді оқып және басқа дереккөздердегі жазбалармен салыстыра отырып құрады. Сондықтан GEO негізінде үш нәрсе тұр: анық мәтін, машина оқи алатын құрылым және сырттай растау.</p>
<h2>Тәжірибеде не істеу керек?</h2>
<ul>
<li><strong>Сұрақ-жауап пішімі.</strong> Нақты клиент сұрақтарын тақырып ретінде жазып, тікелей астында қысқа әрі дәл жауап беріңіз. Модельдер дәл осындай блоктарды дәйексөз ретінде алады.</li>
<li><strong>Фактілерді мәтінге жазыңыз.</strong> Баға аралығы, мерзім, қамтитын қалаңыз, технология атаулары — бұлар сурет ішінде емес, мәтінде болуы керек.</li>
<li><strong>Құрылымдалған дерек.</strong> Organization, FAQPage, Service және Article схемалары сайттың не туралы екенін біржақты білдіреді.</li>
<li><strong>robots.txt-те ЖИ роботтарына қатынас.</strong> GPTBot, ClaudeBot, PerplexityBot сияқты роботтарды әдейі жауып қойған болсаңыз, жауапта көрінуіңіз мүмкін емес.</li>
<li><strong>Сыртқы іздер.</strong> Каталогтар, баспасөз, кәсіби платформалар және клиент пікірлері модельдің сізді «нақты компания» ретінде тануына көмектеседі.</li>
</ul>
<h2>Оны өлшеуге бола ма?</h2>
<p>Әзірге классикалық рейтинг есебіндей дәл емес, бірақ қарапайым тәсіл жұмыс істейді: өзіңіздің және бәсекелестеріңіздің атына қатысты 15-20 әдеттегі сұрақты таңдап, ай сайын сол чат модельдерінде тексеріңіз және жауапта кімнің аты аталғанын белгілеңіз. Бұл GEO жұмысының бағытын көрсету үшін жеткілікті.</p>
<p>Жақсы жаңалық: GEO классикалық SEO-ны алмастырмайды — сол іргетасқа сүйенеді. Техникалық негізі дұрыс сайт бұл жаңа арнада да автоматты түрде алда.</p>
HTML,
                    'uz' => <<<'HTML'
<p>Klassik SEO sizni natijalar roʻyxatiga chiqaradi. GEO (Generative Engine Optimization) esa boshqa savolning javobi: foydalanuvchi ChatGPT, Perplexity yoki Google’ning SI javobidan «Bokudagi ishonchli veb-studiya» deb soʻraganda, javob ichida sizning nomingiz aytiladimi?</p>
<h2>SI javobni qanday quradi?</h2>
<p>Modellar javobni saytingiz dizayniga qarab emas, matnni oʻqib va boshqa manbalardagi qaydlar bilan solishtirib quradi. Shu bois GEO asosida uchta narsa turadi: aniq matn, mashina oʻqiy oladigan tuzilma va tashqi tasdiq.</p>
<h2>Amaliyotda nima qilish kerak?</h2>
<ul>
<li><strong>Savol-javob formati.</strong> Haqiqiy mijoz savollarini sarlavha sifatida yozing va bevosita ostida qisqa, aniq javob bering. Modellar aynan shunday bloklarni iqtibos qiladi.</li>
<li><strong>Faktlarni matnga yozing.</strong> Narx oraligʻi, muddat, qamrab olgan shahringiz, texnologiya nomlari — bular rasm ichida emas, matnda boʻlishi kerak.</li>
<li><strong>Tuzilmali maʼlumot.</strong> Organization, FAQPage, Service va Article sxemalari saytning nima haqida ekanini bir maʼnoda bildiradi.</li>
<li><strong>robots.txt’da SI robotlariga munosabat.</strong> GPTBot, ClaudeBot, PerplexityBot kabi robotlarni ataylab yopib qoʻygan boʻlsangiz, javobda koʻrinishingiz mumkin emas.</li>
<li><strong>Tashqi izlar.</strong> Kataloglar, matbuot, kasbiy platformalar va mijoz sharhlari modelning sizni «haqiqiy kompaniya» sifatida tanishiga yordam beradi.</li>
</ul>
<h2>Buni oʻlchash mumkinmi?</h2>
<p>Hozircha klassik reyting hisoboti kabi aniq emas, ammo oddiy usul ishlaydi: oʻzingiz va raqobatchilaringiz nomiga oid 15-20 tipik savolni tanlab, har oy oʻsha chat modellarida tekshiring va javobda kimning nomi aytilganini qayd eting. Bu GEO ishining yoʻnalishini koʻrsatish uchun yetarli.</p>
<p>Yaxshi xabar: GEO klassik SEO’ni almashtirmaydi — oʻsha poydevorga tayanadi. Texnik asosi toʻgʻri sayt bu yangi kanalda ham avtomatik ravishda oldinda.</p>
HTML,
                ],
            ],
        ];

        foreach ($posts as $data) {
            BlogPost::updateOrCreate(
                ['slug' => $data['slug']],
                $data + ['author_id' => $authorId, 'is_published' => true],
            );
        }
    }
}
