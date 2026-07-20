<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = \App\Models\User::where('role', 'instructor')->get();

        if ($instructors->isEmpty()) {
            return;
        }

        $dummyCourses = [
            [
                'title' => 'Yoruba Oral Literature & Modern Storytelling',
                'tag' => 'yoruba',
                'langs' => ['EN', 'YO'],
                'modules_count' => 4,
                'students_count' => 247,
                'culture_items' => ['yoruba' => 64],
                'avg_completion' => 70,
                'status' => 'Published',
            ],
            [
                'title' => 'Cassava-to-Market: Smallholder Agriculture',
                'tag' => 'hausa',
                'langs' => ['EN', 'HA'],
                'modules_count' => 3,
                'students_count' => 412,
                'culture_items' => ['hausa' => 48],
                'avg_completion' => 65,
                'status' => 'Published',
            ],
            [
                'title' => 'Introduction to Web Development',
                'tag' => 'universal',
                'langs' => ['EN', 'IG'],
                'modules_count' => 3,
                'students_count' => 1184,
                'culture_items' => ['igbo' => 32, 'universal' => 18],
                'avg_completion' => 60,
                'status' => 'Published',
            ],
            [
                'title' => 'Pan-African Business Ethics',
                'tag' => 'panafrican',
                'langs' => ['EN'],
                'modules_count' => 3,
                'students_count' => 318,
                'culture_items' => ['panafrican' => 22],
                'avg_completion' => 62,
                'status' => 'Published',
            ],
            [
                'title' => 'Igbo Craftsmanship & Bronze Casting',
                'tag' => 'igbo',
                'langs' => ['EN', 'IG'],
                'modules_count' => 4,
                'students_count' => 189,
                'culture_items' => ['igbo' => 54],
                'avg_completion' => 75,
                'status' => 'Published',
            ],
            [
                'title' => 'Introduction to Hausa Literature & Proverbs',
                'tag' => 'hausa',
                'langs' => ['EN', 'HA'],
                'modules_count' => 3,
                'students_count' => 295,
                'culture_items' => ['hausa' => 40],
                'avg_completion' => 68,
                'status' => 'Published',
            ],
        ];

        foreach ($instructors as $instructor) {
            foreach ($dummyCourses as $courseData) {
                $course = \App\Models\Course::firstOrCreate(
                    [
                        'instructor_id' => $instructor->id,
                        'title' => $courseData['title'],
                    ],
                    $courseData
                );

                // Create structured modules for the course if none exist
                if ($course->contents()->count() === 0) {
                    if ($courseData['title'] === 'Yoruba Oral Literature & Modern Storytelling') {
                        $course->contents()->create([
                            'type' => 'Reading',
                            'title' => 'Module 1: Origins of Ìjálá Chant',
                            'body' => "Ìjálá is a chanted form of Yoruba poetry traditionally performed by hunters in praise of the deity Ògún, as well as for social critique and entertainment. It relies heavily on vocal control, rhythmic patterns, and deep knowledge of lineage stories (oríkì).",
                            'language' => 'EN',
                            'culture_tag' => 'yoruba',
                        ]);
                        $course->contents()->create([
                            'type' => 'Video',
                            'title' => 'Module 2: Performance of Oríkì',
                            'body' => "Watch a live performance of Oríkì chanting in a Yoruba festival context.",
                            'language' => 'EN',
                            'culture_tag' => 'yoruba',
                        ]);
                        $course->contents()->create([
                            'type' => 'PDF',
                            'title' => 'Module 3: Study Guide on Yoruba Literature',
                            'body' => "Download the study guide on Yoruba oral literature.",
                            'language' => 'EN',
                            'culture_tag' => 'yoruba',
                        ]);
                        $course->contents()->create([
                            'type' => 'Quiz',
                            'title' => 'Module 4: Yoruba Literature Knowledge Check',
                            'body' => json_encode([
                                [
                                    'question' => 'Who is the primary Yoruba deity praised in traditional hunter\'s Ìjálá chanting?',
                                    'options' => ['Sango', 'Ogun', 'Oya', 'Obatala'],
                                    'answer' => 1
                                ],
                                [
                                    'question' => 'Which vocal style is used in performing Ìjálá?',
                                    'options' => ['Monotone reading', 'Rhythmic chanting', 'Silent meditation', 'Western classical singing'],
                                    'answer' => 1
                                ]
                            ]),
                            'language' => 'EN',
                            'culture_tag' => 'yoruba',
                        ]);
                    } elseif ($courseData['title'] === 'Cassava-to-Market: Smallholder Agriculture') {
                        $course->contents()->create([
                            'type' => 'Reading',
                            'title' => 'Module 1: Soil Preparation and Planting',
                            'body' => "Cassava grows best in well-drained loamy soil. When planting, cuttings should be 20-30 cm long with 4-6 nodes, inserted at a 45-degree angle. Weed control in the first three months is crucial for optimal root yields.",
                            'language' => 'EN',
                            'culture_tag' => 'hausa',
                        ]);
                        $course->contents()->create([
                            'type' => 'Video',
                            'title' => 'Module 2: Post-Harvest Processing of Cassava',
                            'body' => "Learn the steps of grating, fermenting, and frying cassava to produce Gari.",
                            'language' => 'EN',
                            'culture_tag' => 'hausa',
                        ]);
                        $course->contents()->create([
                            'type' => 'Quiz',
                            'title' => 'Module 3: Cassava Farming Quiz',
                            'body' => json_encode([
                                [
                                    'question' => 'What is the recommended angle for planting cassava cuttings?',
                                    'options' => ['90 degrees', '45 degrees', '10 degrees', '0 degrees (flat)'],
                                    'answer' => 1
                                ],
                                [
                                    'question' => 'How long should weed control be strictly maintained after planting cassava?',
                                    'options' => ['First week only', 'First three months', 'Just before harvest', 'No weed control needed'],
                                    'answer' => 1
                                ]
                            ]),
                            'language' => 'EN',
                            'culture_tag' => 'hausa',
                        ]);
                    } elseif ($courseData['title'] === 'Introduction to Web Development') {
                        $course->contents()->create([
                            'type' => 'Reading',
                            'title' => 'Module 1: HTML Structure and Tags',
                            'body' => "HTML stands for HyperText Markup Language. It provides the core structure of a webpage using tags like head, body, h1, and p. Learning semantic HTML is essential for accessibility and search engine optimization.",
                            'language' => 'EN',
                            'culture_tag' => 'universal',
                        ]);
                        $course->contents()->create([
                            'type' => 'PDF',
                            'title' => 'Module 2: CSS and Layout Basics Guide',
                            'body' => "CSS (Cascading Style Sheets) controls the colors, spacing, and general layout of HTML elements. Understanding CSS Flexbox and Grid models is fundamental to modern responsive design.",
                            'language' => 'EN',
                            'culture_tag' => 'universal',
                        ]);
                        $course->contents()->create([
                            'type' => 'Quiz',
                            'title' => 'Module 3: Web Development HTML Basics Quiz',
                            'body' => json_encode([
                                [
                                    'question' => 'What does HTML stand for?',
                                    'options' => ['HyperText Markup Language', 'HighTransfer Multi Link', 'Home Tool Markup Language', 'Hyperlink Text Management List'],
                                    'answer' => 0
                                ],
                                [
                                    'question' => 'Which tag is used for the largest heading in HTML?',
                                    'options' => ['<heading>', '<h6>', '<h1>', '<head>'],
                                    'answer' => 2
                                ]
                            ]),
                            'language' => 'EN',
                            'culture_tag' => 'universal',
                        ]);
                    } elseif ($courseData['title'] === 'Pan-African Business Ethics') {
                        $course->contents()->create([
                            'type' => 'Reading',
                            'title' => 'Module 1: Foundations of Ubuntu in Business',
                            'body' => "Ubuntu is a Pan-African philosophy that translates to 'I am because we are.' In business, this emphasizes community well-being, collaborative growth, corporate social responsibility, and ethical relationships with clients over individual profit.",
                            'language' => 'EN',
                            'culture_tag' => 'panafrican',
                        ]);
                        $course->contents()->create([
                            'type' => 'PDF',
                            'title' => 'Module 2: Ethical Sourcing & Sustainability in Africa',
                            'body' => "Review standard policies and case studies on how sustainable business practices preserve natural resources across West African markets.",
                            'language' => 'EN',
                            'culture_tag' => 'panafrican',
                        ]);
                        $course->contents()->create([
                            'type' => 'Quiz',
                            'title' => 'Module 3: Ubuntu Business Philosophy Quiz',
                            'body' => json_encode([
                                [
                                    'question' => 'What does the Pan-African philosophy of Ubuntu emphasize in a business context?',
                                    'options' => ['Maximizing individual profit', 'Community well-being and collaborative growth', 'Aggressive market competition', 'Automated corporate control'],
                                    'answer' => 1
                                ],
                                [
                                    'question' => 'In business ethical frameworks, Ubuntu relates closest to:',
                                    'options' => ['Corporate Social Responsibility', 'Offshore tax schemes', 'Aggressive advertising campaigns', 'Short-term debt financing'],
                                    'answer' => 0
                                ]
                            ]),
                            'language' => 'EN',
                            'culture_tag' => 'panafrican',
                        ]);
                    } elseif ($courseData['title'] === 'Igbo Craftsmanship & Bronze Casting') {
                        $course->contents()->create([
                            'type' => 'Reading',
                            'title' => 'Module 1: History of Igbo-Ukwu Bronze Art',
                            'body' => "Igbo-Ukwu bronzes date back to the 9th century, showing sophisticated metallurgical skills in West Africa. Craftspeople utilized the lost-wax casting technique (cire perdue) to create highly detailed insect motifs, ceremonial vessels, and regalia.",
                            'language' => 'EN',
                            'culture_tag' => 'igbo',
                        ]);
                        $course->contents()->create([
                            'type' => 'Video',
                            'title' => 'Module 2: The Lost-Wax Casting Technique',
                            'body' => "Watch a visual guide demonstrating the traditional lost-wax technique used to smelt and mold copper alloys.",
                            'language' => 'EN',
                            'culture_tag' => 'igbo',
                        ]);
                        $course->contents()->create([
                            'type' => 'PDF',
                            'title' => 'Module 3: Archaeological Discoveries in Southeastern Nigeria',
                            'body' => "Download the documentation on the 1938 Igbo-Ukwu excavations and findings.",
                            'language' => 'EN',
                            'culture_tag' => 'igbo',
                        ]);
                        $course->contents()->create([
                            'type' => 'Quiz',
                            'title' => 'Module 4: Igbo-Ukwu Bronze Casting Quiz',
                            'body' => json_encode([
                                [
                                    'question' => 'Which technique was used by Igbo-Ukwu craftspeople to create bronze art?',
                                    'options' => ['Cold hammering', 'Lost-wax casting', 'Industrial 3D printing', 'Laser carving'],
                                    'answer' => 1
                                ],
                                [
                                    'question' => 'In which century were the sophisticated Igbo-Ukwu bronzes created?',
                                    'options' => ['9th Century', '15th Century', '18th Century', '20th Century'],
                                    'answer' => 0
                                ]
                            ]),
                            'language' => 'EN',
                            'culture_tag' => 'igbo',
                        ]);
                    } elseif ($courseData['title'] === 'Introduction to Hausa Literature & Proverbs') {
                        $course->contents()->create([
                            'type' => 'Reading',
                            'title' => 'Module 1: The Role of Karin Magana (Proverbs)',
                            'body' => "Hausa literature relies heavily on 'Karin Magana' (proverbs) for teaching wisdom, moral standards, and cultural values. Proverbs serve as expressions of community intelligence, often utilizing metaphors related to animals, farming, and daily trade.",
                            'language' => 'EN',
                            'culture_tag' => 'hausa',
                        ]);
                        $course->contents()->create([
                            'type' => 'PDF',
                            'title' => 'Module 2: Compilation of Common Hausa Proverbs',
                            'body' => "Read a detailed compilation of Hausa proverbs and their literal and philosophical translations.",
                            'language' => 'EN',
                            'culture_tag' => 'hausa',
                        ]);
                        $course->contents()->create([
                            'type' => 'Quiz',
                            'title' => 'Module 3: Hausa Proverbs & Wisdom Quiz',
                            'body' => json_encode([
                                [
                                    'question' => 'What is the Hausa term for Proverbs?',
                                    'options' => ['Karin Magana', 'Wakar Baka', 'Tatsuniya', 'Hikima'],
                                    'answer' => 0
                                ],
                                [
                                    'question' => 'What is the primary function of Karin Magana in Hausa society?',
                                    'options' => ['Record keeping', 'Teaching wisdom and moral standards', 'Financial accounting', 'Political campaign slogans'],
                                    'answer' => 1
                                ]
                            ]),
                            'language' => 'EN',
                            'culture_tag' => 'hausa',
                        ]);
                    }
                }
            }
        }
    }
}
