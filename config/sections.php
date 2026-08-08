<?php

/*
|--------------------------------------------------------------------------
| Editable content map
|--------------------------------------------------------------------------
|
| `types` declares the fields of every kind of section. The admin form and the
| public API are both generated from these descriptors — a new kind of block
| needs an entry here and nothing else.
|
| `pages` declares which sections belong to which page. The section key is the
| dotted path the block occupies in the content tree the frontend consumes:
| a section keyed `home.faq` fills `home.faq` in the dictionary, so adding a
| page or a block never requires touching the Next.js code either.
|
| Field descriptor keys:
|   type   text | textarea | rich | list | repeater | image | url | toggle | icon | date | key_values
|   label  admin label (defaults to a humanised name)
|   help   helper text under the field
|   rows   textarea height
|   fields nested descriptors, for `repeater`
|   shared true = one value for all languages (stored outside the locale tabs)
|
| A type may declare `unwrap` — the name of the single field whose value *is*
| the section's value in the content tree (used where the frontend expects a
| bare list rather than an object).
|
*/

$iconField = [
    'type' => 'icon',
    'label' => 'Icon',
    'help' => 'Heroicon name, e.g. heroicon-o-light-bulb',
];

return [

    'types' => [

        /*
        | ---- Layout ------------------------------------------------------
        */

        'site_meta' => [
            'label' => 'Site identity & default meta',
            'fields' => [
                'siteName' => ['type' => 'text', 'label' => 'Site name'],
                'tagline' => ['type' => 'text', 'label' => 'Tagline'],
                'defaultDescription' => ['type' => 'textarea', 'label' => 'Default meta description', 'rows' => 3],
            ],
        ],

        'site_profile' => [
            'label' => 'Brand & social profiles',
            'fields' => [
                'brand' => ['type' => 'text', 'label' => 'Brand name', 'shared' => true],
                'founder' => ['type' => 'text', 'label' => 'Founder', 'shared' => true],
                'domain' => ['type' => 'text', 'label' => 'Domain', 'shared' => true],
                'social.linkedin' => ['type' => 'url', 'label' => 'LinkedIn', 'shared' => true],
                'social.github' => ['type' => 'url', 'label' => 'GitHub', 'shared' => true],
                'social.twitter' => ['type' => 'url', 'label' => 'X / Twitter', 'shared' => true],
                'social.facebook' => ['type' => 'url', 'label' => 'Facebook', 'shared' => true],
                'social.instagram' => ['type' => 'url', 'label' => 'Instagram', 'shared' => true],
                'twitterHandle' => ['type' => 'text', 'label' => 'X / Twitter handle', 'help' => 'With the @, e.g. @h2solutions — used on share cards.', 'shared' => true],
                'ogImage' => ['type' => 'image', 'label' => 'Default share image', 'shared' => true],
                // Structured address and price band: these feed the schema.org
                // markup search engines read, not the visible page.
                'addressLocality' => ['type' => 'text', 'label' => 'City (structured data)', 'help' => 'In English, e.g. Baku', 'shared' => true],
                'addressCountry' => ['type' => 'text', 'label' => 'Country code (structured data)', 'help' => 'Two letters, e.g. AZ', 'shared' => true],
                'priceRange' => ['type' => 'text', 'label' => 'Price range (structured data)', 'help' => 'e.g. $$ — shown by Google for local businesses.', 'shared' => true],
            ],
        ],

        'branding' => [
            'label' => 'Logo & favicon',
            'fields' => [
                'logo' => [
                    'type' => 'image',
                    'label' => 'Logo',
                    'help' => 'Shown in the header and footer. Transparent PNG or SVG, roughly 4:1. Leave empty to keep the built-in H2 wordmark.',
                    'shared' => true,
                ],
                'favicon' => [
                    'type' => 'image',
                    'label' => 'Favicon source',
                    'help' => 'One square PNG/JPG/WebP, at least 512×512. Every other size — including favicon.ico and the Apple touch icons — is generated from it automatically.',
                    'shared' => true,
                ],
                'faviconSvg' => [
                    'type' => 'image',
                    'label' => 'Favicon (SVG, optional)',
                    'help' => 'Vector version used by browsers that support it. Optional.',
                    'shared' => true,
                ],
                'icons' => [
                    'type' => 'image_set',
                    'label' => 'Generated sizes',
                    'help' => 'Rebuilt every time the favicon source changes.',
                    'shared' => true,
                ],
                'themeColor' => [
                    'type' => 'text',
                    'label' => 'Theme colour',
                    'help' => 'Browser UI and PWA colour, e.g. #0d1117',
                    'shared' => true,
                ],
                'backgroundColor' => [
                    'type' => 'text',
                    'label' => 'PWA background colour',
                    'shared' => true,
                ],
                'appName' => ['type' => 'text', 'label' => 'PWA name'],
                'appShortName' => ['type' => 'text', 'label' => 'PWA short name'],
            ],
        ],

        'nav_labels' => [
            'label' => 'Menu labels',
            'fields' => [
                'home' => ['type' => 'text'],
                'about' => ['type' => 'text'],
                'services' => ['type' => 'text'],
                'portfolio' => ['type' => 'text'],
                'blog' => ['type' => 'text'],
                'contact' => ['type' => 'text'],
                'menu' => ['type' => 'text', 'label' => 'Menu (button label)'],
                'close' => ['type' => 'text'],
                'language' => ['type' => 'text'],
            ],
        ],

        'nav_menu' => [
            'label' => 'Header / footer menu',
            'unwrap' => 'items',
            'fields' => [
                'items' => [
                    'type' => 'repeater',
                    'label' => 'Menu items',
                    'itemLabel' => 'label',
                    'fields' => [
                        'label' => ['type' => 'text'],
                        'href' => ['type' => 'text', 'label' => 'Link', 'help' => 'Path under the language prefix, e.g. /services — or a full https:// URL'],
                        'external' => ['type' => 'toggle', 'label' => 'Opens in a new tab'],
                    ],
                ],
            ],
        ],

        'footer' => [
            'label' => 'Footer',
            'fields' => [
                'tagline' => ['type' => 'textarea', 'rows' => 3],
                'navTitle' => ['type' => 'text', 'label' => 'Quick links heading'],
                'servicesTitle' => ['type' => 'text', 'label' => 'Services heading'],
                'contactTitle' => ['type' => 'text', 'label' => 'Contact heading'],
                'rights' => ['type' => 'text', 'label' => 'Rights notice'],
                'madeWith' => ['type' => 'text', 'label' => 'Credit line'],
                'newsletterTitle' => ['type' => 'text'],
                'newsletterText' => ['type' => 'textarea', 'rows' => 2],
                'newsletterPlaceholder' => ['type' => 'text'],
                'newsletterSubmit' => ['type' => 'text'],
                'newsletterSuccess' => ['type' => 'text'],
                'newsletterError' => ['type' => 'text'],
            ],
        ],

        'common_labels' => [
            'label' => 'Shared button & UI labels',
            'fields' => [
                'readMore' => ['type' => 'text'],
                'learnMore' => ['type' => 'text'],
                'getStarted' => ['type' => 'text'],
                'loading' => ['type' => 'text'],
                'back' => ['type' => 'text'],
                'skipToContent' => ['type' => 'text'],
            ],
        ],

        /*
        | ---- Reusable blocks --------------------------------------------
        */

        'hero' => [
            'label' => 'Hero',
            'fields' => [
                'badge' => ['type' => 'text'],
                'title' => ['type' => 'text', 'label' => 'Heading (H1)'],
                'titleAccent' => ['type' => 'text', 'label' => 'Accent phrase', 'help' => 'Trailing part of the heading, printed in the accent colour. Must appear in the heading.'],
                'subtitle' => ['type' => 'textarea', 'rows' => 3],
                'ctaPrimary' => ['type' => 'text', 'label' => 'Primary button'],
                'ctaSecondary' => ['type' => 'text', 'label' => 'Secondary button'],
                'servicesTitle' => ['type' => 'text', 'label' => 'Service grid heading'],
                'services' => [
                    'type' => 'repeater',
                    'label' => 'Service cards',
                    'itemLabel' => 'name',
                    'fields' => [
                        'slug' => ['type' => 'text', 'help' => 'Matches a published service to link the card to its page'],
                        'name' => ['type' => 'text'],
                        'description' => ['type' => 'textarea', 'rows' => 2],
                        'icon' => $iconField,
                    ],
                ],
            ],
        ],

        'cta' => [
            'label' => 'Call to action',
            'fields' => [
                'title' => ['type' => 'text'],
                'subtitle' => ['type' => 'textarea', 'rows' => 2],
            ],
        ],

        'faq' => [
            'label' => 'FAQ',
            'fields' => [
                'label' => ['type' => 'text', 'label' => 'Eyebrow'],
                'title' => ['type' => 'text'],
                'items' => [
                    'type' => 'repeater',
                    'label' => 'Questions',
                    'itemLabel' => 'question',
                    'fields' => [
                        'question' => ['type' => 'text'],
                        'answer' => ['type' => 'textarea', 'rows' => 3],
                    ],
                ],
            ],
        ],

        'steps' => [
            'label' => 'Numbered steps',
            'fields' => [
                'label' => ['type' => 'text', 'label' => 'Eyebrow'],
                'title' => ['type' => 'text'],
                'subtitle' => ['type' => 'textarea', 'rows' => 2],
                'steps' => [
                    'type' => 'repeater',
                    'label' => 'Steps',
                    'itemLabel' => 'title',
                    'fields' => [
                        'title' => ['type' => 'text'],
                        'description' => ['type' => 'textarea', 'rows' => 2],
                        'icon' => $iconField,
                    ],
                ],
            ],
        ],

        'feature_list' => [
            'label' => 'Feature cards',
            'fields' => [
                'label' => ['type' => 'text', 'label' => 'Eyebrow'],
                'title' => ['type' => 'text'],
                'subtitle' => ['type' => 'textarea', 'rows' => 2],
                'items' => [
                    'type' => 'repeater',
                    'label' => 'Cards',
                    'itemLabel' => 'title',
                    'fields' => [
                        'title' => ['type' => 'text'],
                        'description' => ['type' => 'textarea', 'rows' => 3],
                        'icon' => $iconField,
                    ],
                ],
            ],
        ],

        'stat_list' => [
            'label' => 'Figures',
            'fields' => [
                'label' => ['type' => 'text', 'label' => 'Eyebrow'],
                'title' => ['type' => 'text'],
                'subtitle' => ['type' => 'textarea', 'rows' => 2],
                'items' => [
                    'type' => 'repeater',
                    'label' => 'Figures',
                    'itemLabel' => 'value',
                    'fields' => [
                        'value' => ['type' => 'text', 'label' => 'Figure'],
                        'label' => ['type' => 'text', 'label' => 'Caption'],
                    ],
                ],
            ],
        ],

        'fact_list' => [
            'label' => 'Fact rows',
            'unwrap' => 'items',
            'fields' => [
                'items' => [
                    'type' => 'repeater',
                    'label' => 'Facts',
                    'itemLabel' => 'label',
                    'fields' => [
                        'label' => ['type' => 'text'],
                        'value' => ['type' => 'text'],
                    ],
                ],
            ],
        ],

        'stack' => [
            'label' => 'Technology groups',
            'fields' => [
                'label' => ['type' => 'text', 'label' => 'Eyebrow'],
                'title' => ['type' => 'text'],
                'subtitle' => ['type' => 'textarea', 'rows' => 2],
                'groups' => [
                    'type' => 'repeater',
                    'label' => 'Groups',
                    'itemLabel' => 'title',
                    'fields' => [
                        'title' => ['type' => 'text'],
                        'icon' => $iconField,
                        'items' => ['type' => 'list', 'label' => 'Technologies'],
                    ],
                ],
            ],
        ],

        'rich_text' => [
            'label' => 'Text block',
            'fields' => [
                'label' => ['type' => 'text', 'label' => 'Eyebrow'],
                'title' => ['type' => 'text'],
                'body' => ['type' => 'list', 'label' => 'Paragraphs', 'rows' => 4],
            ],
        ],

        'card_teaser' => [
            'label' => 'Section header with card list',
            'fields' => [
                'label' => ['type' => 'text', 'label' => 'Eyebrow'],
                'title' => ['type' => 'text'],
                'viewAll' => ['type' => 'text', 'label' => 'View-all button'],
                'viewCase' => ['type' => 'text', 'label' => 'Card link label'],
                'readMore' => ['type' => 'text', 'label' => 'Card link label (blog)'],
                'samples' => [
                    'type' => 'repeater',
                    'label' => 'Placeholder cards',
                    'itemLabel' => 'title',
                    'help' => 'Only shown while nothing is published yet.',
                    'fields' => [
                        'title' => ['type' => 'text'],
                        'category' => ['type' => 'text'],
                        'date' => ['type' => 'date'],
                    ],
                ],
            ],
        ],

        'key_values' => [
            'label' => 'Custom labels',
            'help' => 'Free-form key/value pairs — use this for copy a new block needs before it gets its own schema.',
            'collapse' => 'pairs',
            'fields' => [
                'pairs' => [
                    'type' => 'key_values',
                    'label' => 'Values',
                ],
            ],
        ],

        /*
        | ---- Page-specific blocks ----------------------------------------
        */

        'about_intro' => [
            'label' => 'About — intro & story',
            'fields' => [
                'label' => ['type' => 'text', 'label' => 'Eyebrow'],
                'title' => ['type' => 'text', 'label' => 'Page heading (H1)'],
                'subtitle' => ['type' => 'textarea', 'rows' => 2],
                'story' => ['type' => 'textarea', 'rows' => 3, 'label' => 'Short story (used as meta description)'],
                'storyLabel' => ['type' => 'text'],
                'storyTitle' => ['type' => 'text'],
                'storyParagraphs' => ['type' => 'list', 'label' => 'Story paragraphs', 'rows' => 4],
                'factsTitle' => ['type' => 'text'],
                'valuesLabel' => ['type' => 'text'],
                'valuesTitle' => ['type' => 'text'],
                'valuesSubtitle' => ['type' => 'textarea', 'rows' => 2],
            ],
        ],

        'founder' => [
            'label' => 'Founder card',
            'fields' => [
                'label' => ['type' => 'text', 'label' => 'Eyebrow'],
                'name' => ['type' => 'text'],
                'role' => ['type' => 'text'],
                'quote' => ['type' => 'textarea', 'rows' => 3],
                'linkedinLabel' => ['type' => 'text', 'label' => 'LinkedIn link label'],
            ],
        ],

        'services_labels' => [
            'label' => 'Services page copy',
            'fields' => [
                'title' => ['type' => 'text', 'label' => 'Page heading (H1)'],
                'intro' => ['type' => 'textarea', 'rows' => 3],
                'included' => ['type' => 'text', 'label' => '"What is included" heading'],
                'related' => ['type' => 'text', 'label' => 'Related services heading'],
                'startTitle' => ['type' => 'text', 'label' => 'Sidebar heading'],
                'startText' => ['type' => 'textarea', 'rows' => 3, 'label' => 'Sidebar text'],
                'empty' => ['type' => 'text', 'label' => 'Empty state'],
            ],
        ],

        'services_preview' => [
            'label' => 'Services teaser labels',
            'fields' => [
                'title' => ['type' => 'text'],
                'subtitle' => ['type' => 'textarea', 'rows' => 2],
                'viewAll' => ['type' => 'text'],
            ],
        ],

        'portfolio_labels' => [
            'label' => 'Portfolio page copy',
            'fields' => [
                'title' => ['type' => 'text', 'label' => 'Page heading (H1)'],
                'subtitle' => ['type' => 'textarea', 'rows' => 3],
                'empty' => ['type' => 'text', 'label' => 'Empty state'],
                'viewCase' => ['type' => 'text', 'label' => 'Card link label'],
                'problemLabel' => ['type' => 'text'],
                'solutionLabel' => ['type' => 'text'],
                'resultLabel' => ['type' => 'text'],
                'overviewTitle' => ['type' => 'text'],
                'galleryTitle' => ['type' => 'text'],
                'galleryHint' => ['type' => 'text'],
                'galleryClose' => ['type' => 'text'],
                'clientLabel' => ['type' => 'text'],
                'yearLabel' => ['type' => 'text'],
                'visitSite' => ['type' => 'text'],
                'related' => ['type' => 'text'],
                'processTitle' => ['type' => 'text'],
            ],
        ],

        'blog_labels' => [
            'label' => 'Blog page copy',
            'fields' => [
                'label' => ['type' => 'text', 'label' => 'Eyebrow'],
                'title' => ['type' => 'text', 'label' => 'Page heading (H1)'],
                'subtitle' => ['type' => 'textarea', 'rows' => 3],
                'empty' => ['type' => 'text', 'label' => 'Empty state'],
                'emptyCta' => ['type' => 'text', 'label' => 'Empty state button'],
                'readMore' => ['type' => 'text'],
                'publishedAt' => ['type' => 'text'],
                'minRead' => ['type' => 'text', 'label' => '"min read" suffix'],
                'featuredLabel' => ['type' => 'text'],
                'latestTitle' => ['type' => 'text'],
                'authorLabel' => ['type' => 'text'],
                'shareLabel' => ['type' => 'text'],
                'related' => ['type' => 'text'],
                'backToList' => ['type' => 'text'],
                'tocTitle' => ['type' => 'text'],
                'helpTitle' => ['type' => 'text', 'label' => 'Article sidebar heading'],
                'helpText' => ['type' => 'textarea', 'rows' => 3, 'label' => 'Article sidebar text'],
            ],
        ],

        'contact_info' => [
            'label' => 'Contact details',
            'fields' => [
                'label' => ['type' => 'text', 'label' => 'Eyebrow'],
                'title' => ['type' => 'text', 'label' => 'Page heading (H1)'],
                'subtitle' => ['type' => 'textarea', 'rows' => 2],
                'infoTitle' => ['type' => 'text'],
                'infoHeading' => ['type' => 'text'],
                'infoSubtitle' => ['type' => 'textarea', 'rows' => 2],
                'emailLabel' => ['type' => 'text'],
                'email' => ['type' => 'text', 'help' => 'Drives the mailto: links across the site'],
                'emailNote' => ['type' => 'text'],
                'phoneLabel' => ['type' => 'text'],
                'phone' => ['type' => 'text', 'help' => 'Drives the tel: and WhatsApp links'],
                'phoneNote' => ['type' => 'text'],
                'whatsappLabel' => ['type' => 'text'],
                'whatsappValue' => ['type' => 'text'],
                'whatsappNote' => ['type' => 'text'],
                'addressLabel' => ['type' => 'text'],
                'address' => ['type' => 'text'],
                'addressNote' => ['type' => 'text'],
                'hoursLabel' => ['type' => 'text'],
                'hours' => ['type' => 'text'],
                'hoursNote' => ['type' => 'text'],
                'responseLabel' => ['type' => 'text'],
                'responseValue' => ['type' => 'text'],
                'mailSubject' => ['type' => 'text', 'label' => 'Default e-mail subject'],
            ],
        ],

        'contact_brief' => [
            'label' => 'Contact — brief panel',
            'fields' => [
                'label' => ['type' => 'text', 'label' => 'Eyebrow'],
                'title' => ['type' => 'text'],
                'text' => ['type' => 'textarea', 'rows' => 3],
                'items' => ['type' => 'list', 'label' => 'Checklist'],
                'cta' => ['type' => 'text', 'label' => 'Button'],
            ],
        ],

        'contact_direct' => [
            'label' => 'Contact — closing band',
            'fields' => [
                'title' => ['type' => 'text'],
                'text' => ['type' => 'textarea', 'rows' => 2],
                'emailCta' => ['type' => 'text'],
                'whatsappCta' => ['type' => 'text'],
                'linkedin' => ['type' => 'text', 'label' => 'LinkedIn link label'],
            ],
        ],

        'not_found' => [
            'label' => '404 page',
            'fields' => [
                'eyebrow' => ['type' => 'text'],
                'title' => ['type' => 'text'],
                'titleAccent' => ['type' => 'text', 'label' => 'Accent phrase'],
                'text' => ['type' => 'textarea', 'rows' => 3],
                'ctaLabel' => ['type' => 'text', 'label' => 'Home button'],
            ],
        ],
    ],

    /*
    | Pages and the sections filed under them. `key` on a section is also the
    | path it fills in the content tree served to the frontend.
    */
    'pages' => [
        'layout' => [
            'group' => 'layout',
            'label' => 'Header, footer & global copy',
            'path' => null,
            'sections' => [
                'meta' => 'site_meta',
                'branding' => 'branding',
                'site' => 'site_profile',
                'nav' => 'nav_labels',
                'navigation' => 'nav_menu',
                'footer' => 'footer',
                'common' => 'common_labels',
            ],
        ],

        'home' => [
            'group' => 'page',
            'label' => 'Home',
            'path' => '/',
            'sections' => [
                'hero' => 'hero',
                'home.projects' => 'card_teaser',
                'home.process' => 'steps',
                'home.cta' => 'cta',
                'home.faq' => 'faq',
                'home.blog' => 'card_teaser',
                'home.seoText' => 'rich_text',
            ],
        ],

        'about' => [
            'group' => 'page',
            'label' => 'About',
            'path' => '/about',
            'sections' => [
                'about' => 'about_intro',
                'about.founder' => 'founder',
                'about.facts' => 'fact_list',
                'about.commitments' => 'stat_list',
                'about.values' => 'feature_list',
                'about.stack' => 'stack',
                'about.audience' => 'feature_list',
            ],
        ],

        'services' => [
            'group' => 'page',
            'label' => 'Services',
            'path' => '/services',
            'sections' => [
                'services' => 'services_labels',
                'servicesPreview' => 'services_preview',
                'usp' => 'feature_list',
            ],
        ],

        'portfolio' => [
            'group' => 'page',
            'label' => 'Portfolio',
            'path' => '/portfolio',
            'sections' => [
                'portfolio' => 'portfolio_labels',
            ],
        ],

        'blog' => [
            'group' => 'page',
            'label' => 'Blog',
            'path' => '/blog',
            'sections' => [
                'blog' => 'blog_labels',
            ],
        ],

        'contact' => [
            'group' => 'page',
            'label' => 'Contact',
            'path' => '/contact',
            'sections' => [
                'contact' => 'contact_info',
                'contact.brief' => 'contact_brief',
                'contact.next' => 'steps',
                'contact.direct' => 'contact_direct',
            ],
        ],

        'not-found' => [
            'group' => 'page',
            'label' => '404',
            'path' => null,
            'sections' => [
                'notFound' => 'not_found',
            ],
        ],

        'service-detail' => [
            'group' => 'template',
            'label' => 'Service detail (template)',
            'path' => '/services/{slug}',
            'sections' => [],
        ],

        'project-detail' => [
            'group' => 'template',
            'label' => 'Project detail (template)',
            'path' => '/portfolio/{slug}',
            'sections' => [],
        ],

        'blog-detail' => [
            'group' => 'template',
            'label' => 'Blog post (template)',
            'path' => '/blog/{slug}',
            'sections' => [],
        ],
    ],
];
