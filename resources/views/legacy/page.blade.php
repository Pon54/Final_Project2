@extends('layouts.legacy')

@section('title', $page->PageName ?? 'Page')

@section('content')

<section class="page-header aboutus_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>{{ $page->PageName }}</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>{{ $page->PageName }}</li>
      </ul>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>

@if($page->type === 'aboutus')
<style>
  .about-box {
    background: #f8f9fa;
    padding: 40px;
    margin-bottom: 30px;
    border-radius: 8px;
    border-top: 4px solid #e74c3c;
    transition: all 0.3s ease;
    cursor: pointer;
  }
  .about-box:hover {
    background: #ffffff;
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    border-top-color: #c0392b;
  }
</style>
<section class="about_us section-padding">
  <div class="container">
    <div class="section-header text-center" style="margin-bottom: 50px;">
      <h2 style="font-size: 32px; font-weight: 700; color: #2c3e50; margin-bottom: 40px;">About Us</h2>
    </div>

    <!-- Our Mission -->
    <div class="about-box">
      <h3 style="font-size: 24px; font-weight: 600; color: #2c3e50; margin-bottom: 20px;">Our Mission</h3>
      <p style="color: #5a6c7d; font-size: 15px; line-height: 1.8; text-align: justify;">
        Our Mission: We aim to make car booking seamless, convenient, and stress-free for every customer. By focusing on reliability, 
        user-friendly technology, and attentive service, we ensure that every step—from browsing available vehicles to completing your 
        trip—is smooth and hassle-free. Our goal is to empower our customers with the freedom to travel on their own terms, anytime and 
        anywhere.
      </p>
    </div>

    <!-- Our Standards -->
    <div class="about-box">
      <h3 style="font-size: 24px; font-weight: 600; color: #2c3e50; margin-bottom: 20px;">Our Standards</h3>
      <p style="color: #5a6c7d; font-size: 15px; line-height: 1.8; text-align: justify;">
        Our Standards: Excellence drives everything we do. We maintain a modern, well-serviced fleet of vehicles and ensure strict quality 
        checks so that every ride meets our high expectations. Our professional support team is always ready to assist, providing 
        guidance and solutions to guarantee safety, comfort, and reliability. By adhering to these standards, we create a trustworthy and 
        consistent experience for every customer.
      </p>
    </div>

    <!-- Our Promise -->
    <div class="about-box">
      <h3 style="font-size: 24px; font-weight: 600; color: #2c3e50; margin-bottom: 20px;">Our Promise</h3>
      <p style="color: #5a6c7d; font-size: 15px; line-height: 1.8; text-align: justify;">
        Our Promise: We promise a dependable and enjoyable journey, placing your comfort, safety, and convenience at the heart of our 
        service. Our commitment is to continually enhance our offerings, adapt to your needs, and provide a booking experience that is 
        simple, transparent, and tailored to you. With us, you can travel confidently, knowing that every detail has been taken care of.
      </p>
    </div>
  </div>
</section>

@elseif($page->type === 'faqs')
<style>
  .faq-box {
    background: #f8f9fa;
    padding: 30px;
    margin-bottom: 20px;
    border-radius: 8px;
    border-top: 4px solid #e74c3c;
    min-height: 100%;
    transition: all 0.3s ease;
    cursor: pointer;
  }
  .faq-box:hover {
    background: #ffffff;
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    border-top-color: #c0392b;
  }
</style>
<section class="about_us section-padding">
  <div class="container">
    <div class="section-header text-center" style="margin-bottom: 50px;">
      <h2 style="font-size: 32px; font-weight: 700; color: #2c3e50; margin-bottom: 40px;">FAQs</h2>
    </div>

    <div class="row">
      <!-- Column 1: Booking & Requirements -->
      <div class="col-md-4">
        <div class="faq-box">
          <h3 style="font-size: 18px; font-weight: 600; color: #e74c3c; margin-bottom: 25px; border-bottom: 2px solid #e74c3c; padding-bottom: 10px;">Booking & Requirements</h3>
          
          <div style="margin-bottom: 25px;">
            <h4 style="font-size: 14px; font-weight: 600; color: #2c3e50; margin-bottom: 10px;">1. How do I book a car?</h4>
            <p style="color: #5a6c7d; font-size: 13px; line-height: 1.6; text-align: justify;">
              You can book a car online through the company's website or app. Select the dealership or pickup location, the rental period, choose your date, time, and preferred vehicle. Confirm the booking by entering your details and completing the payment.
            </p>
          </div>

          <div style="margin-bottom: 25px;">
            <h4 style="font-size: 14px; font-weight: 600; color: #2c3e50; margin-bottom: 10px;">2. What documents do I need?</h4>
            <p style="color: #5a6c7d; font-size: 13px; line-height: 1.6; text-align: justify;">
              For self-drive cars, you need a valid driver's license and a government-issued ID. For chauffeur-driven cars, only basic ID verification is required.
            </p>
          </div>

          <div style="margin-bottom: 25px;">
            <h4 style="font-size: 14px; font-weight: 600; color: #2c3e50; margin-bottom: 10px;">3. Do I need to pay a deposit?</h4>
            <p style="color: #5a6c7d; font-size: 13px; line-height: 1.6; text-align: justify;">
              Most rental companies charge a refundable security deposit. The amount depends on the vehicle type and is refunded after the car is returned in good condition.
            </p>
          </div>
        </div>
      </div>

      <!-- Column 2: Vehicle Information -->
      <div class="col-md-4">
        <div class="faq-box">
          <h3 style="font-size: 18px; font-weight: 600; color: #e74c3c; margin-bottom: 25px; border-bottom: 2px solid #e74c3c; padding-bottom: 10px;">Vehicle Information</h3>
          
          <div style="margin-bottom: 25px;">
            <h4 style="font-size: 14px; font-weight: 600; color: #2c3e50; margin-bottom: 10px;">4. What types of cars are available?</h4>
            <p style="color: #5a6c7d; font-size: 13px; line-height: 1.6; text-align: justify;">
              Options usually include hatchbacks, sedans, SUVs, luxury cars, and sometimes electric vehicles. Availability may vary based on location.
            </p>
          </div>

          <div style="margin-bottom: 25px;">
            <h4 style="font-size: 14px; font-weight: 600; color: #2c3e50; margin-bottom: 10px;">5. Can I cancel or modify my booking?</h4>
            <p style="color: #5a6c7d; font-size: 13px; line-height: 1.6; text-align: justify;">
              Yes. Many companies allow free cancellation up to a certain time before pickup. Modifications depend on availability and policy terms.
            </p>
          </div>

          <div style="margin-bottom: 25px;">
            <h4 style="font-size: 14px; font-weight: 600; color: #2c3e50; margin-bottom: 10px;">6. Is fuel included in the price?</h4>
            <p style="color: #5a6c7d; font-size: 13px; line-height: 1.6; text-align: justify;">
              Fuel inclusion depends on the package you choose. Some packages include fuel, while others follow a full-to-full policy where you return the car with a full tank. Additional charges may apply based on the specific package selected.
            </p>
          </div>
        </div>
      </div>

      <!-- Column 3: Additional Services -->
      <div class="col-md-4">
        <div class="faq-box">
          <h3 style="font-size: 18px; font-weight: 600; color: #e74c3c; margin-bottom: 25px; border-bottom: 2px solid #e74c3c; padding-bottom: 10px;">Additional Services</h3>
          
          <div style="margin-bottom: 25px;">
            <h4 style="font-size: 14px; font-weight: 600; color: #2c3e50; margin-bottom: 10px;">7. What if the car breaks down?</h4>
            <p style="color: #5a6c7d; font-size: 13px; line-height: 1.6; text-align: justify;">
              You can contact the company's roadside assistance. Most services provide help for breakdowns, flat tires, or emergencies.
            </p>
          </div>

          <div style="margin-bottom: 25px;">
            <h4 style="font-size: 14px; font-weight: 600; color: #2c3e50; margin-bottom: 10px;">8. Is insurance included?</h4>
            <p style="color: #5a6c7d; font-size: 13px; line-height: 1.6; text-align: justify;">
              Basic insurance is usually included. Extra protection, such as collision damage waivers, may be available at an additional cost.
            </p>
          </div>

          <div style="margin-bottom: 25px;">
            <h4 style="font-size: 14px; font-weight: 600; color: #2c3e50; margin-bottom: 10px;">9. Can someone else drive the car?</h4>
            <p style="color: #5a6c7d; font-size: 13px; line-height: 1.6; text-align: justify;">
              Yes, but additional drivers must be registered at pickup and provide valid identification and a driver's license.
            </p>
          </div>

          <div style="margin-bottom: 0;">
            <h4 style="font-size: 14px; font-weight: 600; color: #2c3e50; margin-bottom: 10px;">10. Are there mileage limits?</h4>
            <p style="color: #5a6c7d; font-size: 13px; line-height: 1.6; text-align: justify;">
              Some bookings come with unlimited kilometers, while others have a daily limit. Extra charges may apply if you exceed the limit.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@elseif($page->type === 'terms' || $page->type === 'privacy')
<style>
  .terms-box {
    background: #f8f9fa;
    padding: 50px;
    border-radius: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
  }
  .terms-box:hover {
    background: #ffffff;
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  }
</style>
<section class="about_us section-padding">
  <div class="container">
    <div class="section-header text-center" style="margin-bottom: 50px;">
      <h2 style="font-size: 32px; font-weight: 700; color: #2c3e50; margin-bottom: 20px;">{{ $page->PageName }}</h2>
      <div style="width: 100%; height: 3px; background: #e74c3c; margin: 0 auto;"></div>
    </div>

    <div class="terms-box">
      <div style="color: #5a6c7d; font-size: 14px; line-height: 1.8; text-align: justify;">
        @if($page->type === 'terms')
          <p style="margin-bottom: 25px;">
            These Terms and Conditions govern your access to and use of our website, mobile application, and related services. By using our Service, 
            you agree to be bound by these terms. If you do not agree, you must discontinue use immediately. You may be required to create an 
            account to use certain features, and you are responsible for keeping your login details secure. All information you provide must be 
            accurate, complete, and up-to-date, and you agree not to share your account with others or use another person's account without 
            permission.
          </p>

          <p style="margin-bottom: 25px;">
            Use of our Service is permitted only for lawful purposes. You agree not to misuse the platform, attempt unauthorized access, interfere with 
            system performance, or engage in any activity that could harm the Service or other users. All content, trademarks, and intellectual property 
            displayed on the Service belong to us or our licensors and may not be copied, distributed, or used without prior written consent. Any 
            promotional offers, discounts, or pricing are subject to change at our discretion and may be withdrawn at any time without notice.
          </p>

          <p style="margin-bottom: 25px;">
            Payments made through the Service must be valid and authorized, and you agree to pay all charges incurred in connection with your use. 
            In the event of disputes, unauthorized transactions, or billing errors, you must notify us promptly. We may modify, suspend, or terminate 
            the Service or your access at any time if we believe you have violated these Terms or for any reason deemed necessary for the protection 
            of the platform. We also reserve the right to update these Terms at any time, and the most recent version will always be posted on our 
            platform. Your continued use of the Service constitutes acceptance of any changes.
          </p>

          <p style="margin-bottom: 0;">
            Our Service is provided "as is" and "as available," without warranties of any kind, whether express or implied. We do not guarantee 
            uninterrupted access, error-free operation, or total security. To the fullest extent permitted by law, we are not liable for any damages arising 
            from your use of the Service, including but not limited to loss of data, revenue, or business. Certain jurisdictions do not allow the exclusion 
            of implied warranties, so some limitations may not apply to you. You agree to indemnify and hold us harmless from any claims, damages, 
            or expenses resulting from your misuse of the Service or violation of these Terms.
          </p>
        @else
          {!! $page->detail !!}
        @endif
      </div>
    </div>
  </div>
</section>

@else
<section class="about_us section-padding">
  <div class="container">
    <div class="section-header text-center">
      <h2>{{ $page->PageName }}</h2>
      
      @if($page->type === 'faqs')
        @php
          // Parse FAQs into three columns from database content
          $content = strip_tags($page->detail);
          $faqs = [];
          
          // Split by question numbers (1. 2. 3. etc.)
          preg_match_all('/(\d+)\.\s*([^\r\n]+)[\r\n]+(.*?)(?=\d+\.|$)/s', $content, $matches, PREG_SET_ORDER);
          
          foreach($matches as $match) {
            $faqs[] = [
              'number' => $match[1],
              'question' => trim($match[2]),
              'answer' => trim($match[3])
            ];
          }
          
          // Define column headers and items
          $columns = [
            ['title' => 'Booking & Requirements', 'items' => array_slice($faqs, 0, 3)],
            ['title' => 'Vehicle Information', 'items' => array_slice($faqs, 3, 3)],
            ['title' => 'Additional Services', 'items' => array_slice($faqs, 6, 4)]
          ];
        @endphp
        
        <!-- Three Column Layout for FAQs -->
        <div class="row faq-columns">
          @foreach($columns as $column)
          <div class="col-md-4">
            <div class="faq-box">
              <h3>{{ $column['title'] }}</h3>
              <div class="faq-content">
                @foreach($column['items'] as $faq)
                  <p><strong>{{ $faq['number'] }}. {{ $faq['question'] }}</strong><br>
                  {{ $faq['answer'] }}</p>
                @endforeach
              </div>
            </div>
          </div>
          @endforeach
        </div>
      @elseif($page->type === 'aboutus')
        @php
          // Parse About Us content into three sections
          $content = strip_tags($page->detail);
          // Handle both Unix (\n\n) and Windows (\r\n\r\n) line breaks
          $content = str_replace("\r\n", "\n", $content);
          $paragraphs = array_filter(array_map('trim', preg_split('/\n\s*\n/', $content)));
          $paragraphs = array_values($paragraphs);
        @endphp
        
        <!-- Single Centered Box for About Us with Three Sections -->
        <div class="row">
          <div class="col-12">
            <div class="about-single-box mx-auto">
              <div class="about-sections-wrapper">
                <div class="about-section">
                  <h3 class="section-title">Our Mission</h3>
                  <div class="about-content">
                    <p>{{ $paragraphs[0] ?? '' }}</p>
                  </div>
                </div>
                
                <div class="about-section">
                  <h3 class="section-title">Our Standards</h3>
                  <div class="about-content">
                    <p>{{ $paragraphs[1] ?? '' }}</p>
                  </div>
                </div>
                
                <div class="about-section">
                  <h3 class="section-title">Our Promise</h3>
                  <div class="about-content">
                    <p>{{ $paragraphs[2] ?? '' }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @elseif($page->type === 'privacy' || $page->type === 'terms')
        <!-- Single Centered Box for Privacy/Terms -->
        <div class="row">
          <div class="col-12">
            <div class="privacy-box mx-auto">
              <div class="privacy-content">
                {!! nl2br(e($page->detail)) !!}
              </div>
            </div>
          </div>
        </div>
      @else
        <!-- Original layout for other pages -->
        <div style="text-align: justify;">{!! $page->detail !!}</div>
      @endif
    </div>
  </div>
</section>
@endif

<style>
.section-header p,
.section-header div {
  text-align: justify !important;
  text-justify: inter-word;
  line-height: 1.8 !important;
  margin-bottom: 15px !important;
}

.section-header div p {
  margin-bottom: 20px !important;
  line-height: 1.8 !important;
}

.section-header h2 {
  margin-bottom: 30px !important;
}

.section-header ul,
.section-header ol {
  text-align: justify !important;
  margin-bottom: 20px !important;
  line-height: 1.8 !important;
  padding-left: 20px !important;
}

.section-header li {
  margin-bottom: 20px !important;
  padding-left: 10px !important;
  line-height: 1.8 !important;
}

/* FAQ specific styling */
.section-header ol li {
  margin-bottom: 25px !important;
  padding: 0 !important;
  background: transparent;
  border: none;
}

.section-header ol li:last-child {
  margin-bottom: 0 !important;
}

/* Three Column FAQ Layout */
.faq-columns {
  margin-top: 40px;
  text-align: left;
  display: flex;
  align-items: stretch;
}

.faq-columns .col-md-4 {
  display: flex;
  margin-bottom: 0;
}

.faq-box {
  background: #f8f9fa;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  width: 100%;
  display: flex;
  flex-direction: column;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.faq-box:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

.faq-box h3 {
  color: #fa2837;
  font-size: 20px;
  font-weight: 700;
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 2px solid #fa2837;
  text-align: center;
  flex-shrink: 0;
}

.faq-content {
  flex-grow: 1;
}

.faq-content p {
  margin-bottom: 20px !important;
  line-height: 1.6 !important;
  text-align: justify !important;
  color: #555;
}

.faq-content p strong {
  color: #333;
  display: block;
  margin-bottom: 8px;
  font-size: 15px;
}

.faq-content p:last-child {
  margin-bottom: 0 !important;
}

/* About Us specific styling */
.about-box {
  background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
  border-top: 4px solid #fa2837;
}

.about-box h3 {
  color: #2c3e50;
  font-size: 22px;
  border-bottom: 2px solid #e0e0e0;
}

.about-box:hover {
  border-top-color: #d41f2e;
}

.about-box .faq-content p {
  font-size: 15px;
  line-height: 1.8 !important;
  color: #444;
  text-align: justify !important;
}

/* Single Centered About Us Box */
.about-single-box {
  background: #f8f9fa;
  padding: 60px 80px;
  border-radius: 10px;
  box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
  border-top: 4px solid #fa2837;
  margin: 40px auto;
  max-width: 1200px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.about-single-box:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
}

.about-sections-wrapper {
  display: flex;
  flex-direction: column;
  gap: 40px;
}

.about-section {
  text-align: center;
}

.section-title {
  color: #2c3e50;
  font-size: 24px;
  font-weight: 700;
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 2px solid #e0e0e0;
  display: inline-block;
  min-width: 250px;
}

.about-content {
  text-align: center;
  color: #555;
  font-size: 18px;
  line-height: 2.2 !important;
}

.about-content p {
  margin: 0;
}

/* Single Centered Privacy/Terms Box */
.privacy-box {
  background: #f8f9fa;
  padding: 60px 80px;
  border-radius: 10px;
  box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
  border-top: 4px solid #fa2837;
  margin: 40px auto;
  max-width: 1200px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.privacy-box:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
}

.privacy-content {
  text-align: center;
  color: #555;
  font-size: 16px;
  line-height: 2 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .faq-columns {
    display: block;
  }
  
  .faq-columns .col-md-4 {
    margin-bottom: 20px;
  }
  
  .faq-columns .col-md-4:last-child {
    margin-bottom: 0;
  }
  
  .faq-box {
    height: auto;
  }
}
</style>

@endsection
