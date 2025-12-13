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
