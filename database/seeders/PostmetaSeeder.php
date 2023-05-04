<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Postmeta;
class PostmetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    $postmetas = array(
  array('id' => '1','post_id' => '1','key' => 'excerpt','value' => 'A chatbot is always available to serve your customer 24/7. A chatbot can save you a lot of time and money by automating repetitive tasks like qualifying leads or answering questions of your customers. By offering instatily response to your customer, your business will build trust and boost conversions and sales.'),
  array('id' => '2','post_id' => '2','key' => 'excerpt','value' => 'No, you only need a email to sign up.'),
  array('id' => '3','post_id' => '3','key' => 'excerpt','value' => 'Yes, If you are unhappy with our service, we offer 30 days money-back guarantee on any plan.'),
  array('id' => '4','post_id' => '4','key' => 'excerpt','value' => '{"facebook":"https:\\/\\/www.facebook.com\\/","twitter":"https:\\/\\/twitter.com\\/","linkedin":"https:\\/\\/linkedin.com\\/","instagram":"https:\\/\\/www.instagram.com\\/"}'),
  array('id' => '5','post_id' => '4','key' => 'description','value' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'),
  array('id' => '6','post_id' => '4','key' => 'preview','value' => '/uploads/23/03/1678125197LZ4zAxvVjarz0PrmZCqK.png'),
  array('id' => '7','post_id' => '5','key' => 'excerpt','value' => '{"facebook":"https:\\/\\/www.facebook.com\\/","twitter":"https:\\/\\/twitter.com\\/","linkedin":"https:\\/\\/linkedin.com\\/","instagram":"https:\\/\\/www.instagram.com\\/"}'),
  array('id' => '8','post_id' => '5','key' => 'description','value' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'),
  array('id' => '9','post_id' => '5','key' => 'preview','value' => '/uploads/23/03/1678125246G7FoUHHxe2C88n1cVXCq.png'),
  array('id' => '10','post_id' => '6','key' => 'excerpt','value' => '{"facebook":"https:\\/\\/www.facebook.com\\/","twitter":"https:\\/\\/twitter.com\\/","linkedin":"https:\\/\\/linkedin.com\\/","instagram":"https:\\/\\/www.instagram.com\\/"}'),
  array('id' => '11','post_id' => '6','key' => 'description','value' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'),
  array('id' => '12','post_id' => '6','key' => 'preview','value' => '/uploads/23/03/16781252849ApdWcy0jUhLRb9QtCL4.png'),
  array('id' => '13','post_id' => '7','key' => 'excerpt','value' => '{"facebook":"https:\\/\\/www.facebook.com\\/","twitter":"https:\\/\\/twitter.com\\/","linkedin":"https:\\/\\/linkedin.com\\/","instagram":"https:\\/\\/www.instagram.com\\/"}'),
  array('id' => '14','post_id' => '7','key' => 'description','value' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'),
  array('id' => '15','post_id' => '7','key' => 'preview','value' => '/uploads/23/03/1678125323UINo4L0ZND1ErxlWCAFu.png'),
  array('id' => '16','post_id' => '8','key' => 'preview','value' => '/uploads/23/03/1678128734p2mgTWEhEKwm5MsxhunY.png'),
  array('id' => '17','post_id' => '8','key' => 'short_description','value' => 'In a world that’s increasingly getting commoditized, thanks to technology, it’s an open secret that customer focus is the real differentiator. This Gospel truth is germane to every business function, but in marketing it’s indispensable. Reason being the constantly changing needs, wants and desires of customers. New age marketing therefore, is all about unique individual experiences through tools that bring brands closer to their customer.'),
  array('id' => '18','post_id' => '8','key' => 'main_description','value' => 'Today there’s literally an ocean when it comes to the number of available tools for marketers but none comes close to the effectiveness of QBM. Quality Based Messaging or QBM is a feature under WhatsApp business API which helps businesses engage customers through contextual messaging. These messages need to meet the quality criteria defined by WhatsApp and hence the name- Quality Based Messaging.'),
  array('id' => '19','post_id' => '8','key' => 'seo','value' => '{"title":"Boost your business growth with WhatsApp Quality Based Messaging","description":"In a world that\\u2019s increasingly getting commoditized, thanks to technology, it\\u2019s an open secret that customer focus is the real differentiator. This Gospel truth is germane to every business function, but in marketing it\\u2019s indispensable. Reason being the constantly changing needs, wants and desires of customers. New age marketing therefore, is all about unique individual experiences through tools that bring brands closer to their customer.","tags":"wa, whatsapp, devstation, qserve, whatsserve, whatserder"}'),
  array('id' => '20','post_id' => '9','key' => 'preview','value' => '/uploads/23/03/1678129064eIpoGudjOtETN0JhQRzG.png'),
  array('id' => '21','post_id' => '9','key' => 'short_description','value' => 'In the competitive business landscape, if there’s one thing that has led to the massive growth of internet businesses, it is digital advertising. The $600 billion industry holds an outsized control on customers—- who buys what and thus to the fortunes of these businesses. An interesting aspect of digital advertising is its dynamic and ever-evolving nature, from search ads to video and voice search with the latest being Click to Chat ads. Click to Chat ads, although at a nascent stage currently,'),
  array('id' => '22','post_id' => '9','key' => 'main_description','value' => 'In Feynman speak, Click to Chat ads are ads that are conversational in nature. With precise targeting, marketers are finding it to be much more effective in addressing the shortcomings of typical digital ads.

         Before delving deeper into Click to Chat ads, it’s important to understand imperfections in the digital ad industry which have made way for this new form of advertising. The world moved from traditional mass media advertising to digital ads as the audience had moved online and targeting audience segments on digital was easy. 

         But while digital solved the problem of targeting, it lacked two-way conversations where users could be engaged and their doubts settled.

         The customer does not have a choice today, if they want to connect with the advertised brand for clarity on product /service or instantly perform a transaction. Website landing pages are better suited for savvy internet users who are adept at browsing through multiple pages.They are not for technology newbies. Moreover, a landing page is not the ideal destination in case of products such as jewelry, furniture, real estate and financial services where guided selling works best. 

         Take for example- jewelry. A beautiful model wearing a stylish looking pendant set may entice a user to click on the ad and enter a landing page. But leaves this user unanswered for common questions such as- exchange policy, the kind of gemstones used in the pendant etc.'),
  array('id' => '23','post_id' => '9','key' => 'seo','value' => '{"title":"Click to Chat ads on WhatsApp- A vital tool for your marketing arsenal","description":"In the competitive business landscape, if there\\u2019s one thing that has led to the massive growth of internet businesses, it is digital advertising. The $600 billion industry holds an outsized control on customers\\u2014- who buys what and thus to the fortunes of these businesses. An interesting aspect of digital advertising is its dynamic and ever-evolving nature, from search ads to video and voice search with the latest being Click to Chat ads. Click to Chat ads, although at a nascent stage currently,","tags":"wa, whatsapp, devstation, wasender, whatsserve","image":"\\/uploads\\/23\\/03\\/1678129064ZCzwbv9lHINvkGVXBH2R.png"}'),
  array('id' => '24','post_id' => '10','key' => 'preview','value' => '/uploads/23/03/16781292529emrzSmYnHCskq8JUxIb.png'),
  array('id' => '25','post_id' => '10','key' => 'short_description','value' => 'ChatGPT (Conversational Generative Pre-trained Transformer) is a newly released open-source conversational AI platform. It has been praised for its ability to generate natural language responses to user inputs, and many have hailed it as the next step in creating more human-like conversations. However, despite its promise, certain limitations still prevent it from being a viable replacement for other conversational AI platforms. Let’s explore these limitations and how they can be addressed.'),
  array('id' => '26','post_id' => '10','key' => 'main_description','value' => 'How is ChatGPT different from Conversational AI?
        As an AI language model, ChatGPT can provide conversational capabilities that can be helpful for certain use cases, such as answering general questions or providing basic support. However, it is not designed to replace enterprise conversational AI platforms for several reasons:

        Fine-tuning and customization: Enterprise conversational AI platforms can be customized to meet specific business needs and integrate with their existing systems of records, providing a more tailored solution. ChatGPT, on the other hand, is a general-purpose AI language model and may not be able to meet the specific needs of every business.
        Security and compliance: Enterprise conversational AI platforms often have security and compliance features built-in, ensuring that sensitive data is protected and regulatory requirements are met. ChatGPT is not specifically designed for enterprise-level security and compliance requirements.
        Integrations: Enterprise conversational AI platforms can integrate with other systems and applications, allowing for a more seamless experience for users. ChatGPT does not have the same level of integration capabilities.
        Support and maintenance: Enterprise conversational AI platforms often provide support and maintenance services to ensure that the system is running smoothly and to address any issues that arise. ChatGPT does not provide this level of support and maintenance.
        Scalability: Enterprise conversational AI platforms can be scaled to handle large volumes of user interactions, while ChatGPT may not be able to handle the same level of scalability.
        In summary, while ChatGPT can provide conversational capabilities for certain use cases, it is not designed to replace enterprise conversational AI platforms, which offer greater customization, security, integration, support, maintenance, and scalability capabilities to meet the needs of large businesses.'),
  array('id' => '27','post_id' => '10','key' => 'seo','value' => '{"title":"Why ChatGPT Cannot Replace Conversational AI Platforms?","description":"ChatGPT (Conversational Generative Pre-trained Transformer) is a newly released open-source conversational AI platform. It has been praised for its ability to generate natural language responses to user inputs, and many have hailed it as the next step in creating more human-like conversations. However, despite its promise, certain limitations still prevent it from being a viable replacement for other conversational AI platforms. Let\\u2019s explore these limitations and how they can be addressed.","tags":"wa, whatsapp, devstation, qserve, whatsserve","image":"\\/uploads\\/23\\/03\\/16781292529yMlP8qfUEaRjJic39bs.png"}'),
  array('id' => '30','post_id' => '12','key' => 'excerpt','value' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.'),
  array('id' => '31','post_id' => '12','key' => 'preview','value' => '/uploads/23/03/1678130604XsBOBA2JdT4D3dUMsVPO.jpg'),
  array('id' => '32','post_id' => '13','key' => 'excerpt','value' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum'),
  array('id' => '33','post_id' => '13','key' => 'preview','value' => '/uploads/23/03/1678130652BHfP85klZ25vaXpBU6AT.jpg'),
  array('id' => '34','post_id' => '14','key' => 'excerpt','value' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s'),
  array('id' => '35','post_id' => '14','key' => 'preview','value' => '/uploads/23/03/1678130699E0RrnxKNI6tkb6Qc1eV1.jpg'),
  array('id' => '36','post_id' => '15','key' => 'excerpt','value' => 'Boost digital finance adoption with instant balance inquiries, portfolio recommendations, hassle-free claims settlement, cross-sell and more'),
  array('id' => '37','post_id' => '16','key' => 'excerpt','value' => 'Revolutionize your restaurant operations with WhatsApp-based ordering, meal and add-on recommendations, payments and real-time delivery updates'),
  array('id' => '38','post_id' => '17','key' => 'excerpt','value' => 'Create multistage campaigns in just a few clicks and plan your campaigns ahead of time with pre-built templates'),
  array('id' => '39','post_id' => '17','key' => 'main_description','value' => 'Create multistage campaigns in just a few clicks and plan your campaigns ahead of time with pre-built templates Adapt customer journeys based on real-time events. such as purchases, browses, or any event unique to your customers Seamlessly integrate with marketing tools and CRMs like Clevertap and Moengage to send tailored campaigns'),
  array('id' => '40','post_id' => '17','key' => 'preview','value' => '/uploads/23/03/1678143851hf9IuC24SAhOJ1dLId94.png'),
  array('id' => '41','post_id' => '17','key' => 'banner','value' => '/uploads/23/03/1678143446kru2cExnnwONsqF55Nc6.png'),
  array('id' => '42','post_id' => '18','key' => 'excerpt','value' => 'WhatsApp lets you add buttons to message templates. There are two types of buttons: Quick replies and Call to action buttons. These buttons open up many opportunities for businesses worldwide to engage with their customers on WhatsApp, one of the most popular messaging applications.'),
  array('id' => '43','post_id' => '18','key' => 'main_description','value' => 'WhatsApp lets you add buttons to message templates. There are two types of buttons: Quick replies and Call to action buttons. These buttons open up many opportunities for businesses worldwide to engage with their customers on WhatsApp, one of the most popular messaging applications. Quick replies let businesses define buttons that users can tap to respond. When a Quick reply is tapped, a message containing the button text is sent in the conversation. Call to action buttons trigger a phone call or open a website when tapped. Please note that at this time, WhatsApp does not support deeplinks. To use buttons, you need to submit them as part of a message template to WhatsApp. Once approved, templates containing buttons can be sent by sending the message text in your API request.'),
  array('id' => '44','post_id' => '18','key' => 'preview','value' => '/uploads/23/03/1678144536donXXxCjluUjy3vZEjEO.png'),
  array('id' => '45','post_id' => '18','key' => 'banner','value' => '/uploads/23/03/1678177857DqLCX7BJooFwWYFnY3mH.png'),
  array('id' => '46','post_id' => '19','key' => 'excerpt','value' => 'If you are looking for how to set auto-reply in WhatsApp business and WhatsApp auto-reply message sample, you are at the right place. In this post, we’ll help you understand the nitty-gritty of WhatsApp Chatbots. To start off with, let’s talk about how auto-response for WhatsApp works.'),
  array('id' => '47','post_id' => '19','key' => 'main_description','value' => 'Why do you need the WhatsApp auto-reply feature?
        It is obvious that auto-reply is an essential feature for every kind of business.

        But why? Let us elaborate.

        Instant messaging, in its essence, is meant to be immediate at all times. WhatsApp as a platform has more than 2 billion users available and active at varied times.
        Businesses move to WhatsApp to take advantage of this very fact, but unfortunately, this isn\'t always possible due to reasons like limited working hours and a shortage of human resources.

        This is where WhatsApp Auto-replies come in. 

        With auto-replies, you can always be available to greet and respond to customers even outside your working hours. This allows you to: 

        Be available to your customers 24/7
        Make a strong impression on new customers by greeting them with a customised welcome message.
        Inform your customers about your available hours and set a response time expectation.
        Collect customer data using a pre-chat survey quiz or through AI automated conversations
        This increases customer satisfaction and gives your business an upper hand against competitors. WhatsApp auto replies make life much easier for all growing businesses.'),
  array('id' => '48','post_id' => '19','key' => 'preview','value' => '/uploads/23/03/1678145544w3aon4jCrAciwsSaTXCo.png'),
  array('id' => '49','post_id' => '19','key' => 'banner','value' => '/uploads/23/03/1678178152NI8xZNWqa96WzC13Aytg.gif'),
  array('id' => '50','post_id' => '20','key' => 'excerpt','value' => 'WhatsApp users can schedule posts on the app to plan and send text, photos or videos. The posts can be scheduled for WhatsApp business or to send wishes on birthdays and festivals.'),
  array('id' => '51','post_id' => '20','key' => 'main_description','value' => 'With 2 billion+ active users, WhatsApp is the most widely used communication app. WhatsApp allows you to share text messages, multi-media, location & now money. With all these useful features, you may want to schedule a WhatsApp message for wishing someone their birthday or remind your friends about some events. Or if you’re a business, you may want to schedule payment reminders on the last day of subscriptions or cart reminders to your customers’ WhatsApp. Or, your business needs to automate WhatsApp Business greeting messages to all new customers/subscribers.'),
  array('id' => '52','post_id' => '20','key' => 'preview','value' => '/uploads/23/03/1678176166I16bhCDLteYzyEXmiydB.png'),
  array('id' => '53','post_id' => '20','key' => 'banner','value' => '/uploads/23/03/16781761667IC0JxTR0A4nDQ3pPkPn.webp'),
  array('id' => '54','post_id' => '21','key' => 'excerpt','value' => 'WA Bulk messaging is the dissemination of large numbers of messages for delivery to WASender software. It is used by media companies, banks and other enterprises and consumer brands for a variety of purposes including entertainment, enterprise and mobile marketing.'),
  array('id' => '55','post_id' => '21','key' => 'main_description','value' => 'A bulk message is a message that is sent from a single WhatsApp Business user to multiple phone numbers at the same time. All receivers of the message will see it coming in as a private message. WhatsApp bulk messaging first was a consumer-only feature, but it’s now also available for businesses. For businesses, this means they can now also use WhatsApp for outbound marketing activities.'),
  array('id' => '56','post_id' => '21','key' => 'preview','value' => '/uploads/23/03/167817697016QUKcDn2rlERcMDuR2p.png'),
  array('id' => '57','post_id' => '21','key' => 'banner','value' => '/uploads/23/03/1678177795QbOsO2mocgkgO8NRF071.png'),
  array('id' => '58','post_id' => '22','key' => 'excerpt','value' => 'Representational state transfer is a software architectural style that describes the architecture of the Web.'),
  array('id' => '59','post_id' => '22','key' => 'main_description','value' => 'An API is a set of definitions and protocols for building and integrating application software. It’s sometimes referred to as a contract between an information provider and an information user—establishing the content required from the consumer (the call) and the content required by the producer (the response). For example, the API design for a weather service could specify that the user supply a zip code and that the producer reply with a 2-part answer, the first being the high temperature, and the second being the low.'),
  array('id' => '60','post_id' => '22','key' => 'preview','value' => '/uploads/23/03/1678177358eT0wu71Go2ANWmiEVTrP.png'),
  array('id' => '61','post_id' => '22','key' => 'banner','value' => '/uploads/23/03/16781773587loKRma922J59f5EOXHQ.png'),
  array('id' => '62','post_id' => '23','key' => 'excerpt','value' => 'WASender is the best quaint james bond victoria sponge happy days cras.'),
  array('id' => '63','post_id' => '24','key' => 'excerpt','value' => 'No you can simply register with your email'),
  array('id' => '64','post_id' => '25','key' => 'excerpt','value' => 'WASender has supported free 10 days trial. You don\'t need to add credit card information.'),
  array('id' => '65','post_id' => '26','key' => 'description','value' => 'What is Lorem Ipsum?
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

Why do we use it?
It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).'),
  array('id' => '66','post_id' => '26','key' => 'seo','value' => '{"title":"terms and conditions","description":"orem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, w","tags":"wa, whatsapp, devstation, qserve, whatsserve"}')
);

   Postmeta::insert($postmetas);
  }
}
