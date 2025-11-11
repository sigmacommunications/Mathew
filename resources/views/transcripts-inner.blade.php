 

@extends('layouts.app')
<style>
        #pdf-container {
            display: flex;
            flex-direction: column; /* Display pages vertically */
            align-items: center;
        }
        #pdf-render {
            border: 1px solid #ccc; /* Add border for better visibility */
        }
        .pdf-page {
            margin-bottom: 10px; /* Adjust spacing between pages */
            border: 1px solid #ccc; /* Add border for better visibility */
        }
        
        .btndiv-inner {
            background: #fff;
            height: 50px;
            width: 15%;
            display: flex;
            align-items: center;
            justify-content: space-around;
            gap: 0px;
            box-shadow: 0 1px 4px rgba(0,0,0,.3);
            margin-top: -118px;
        }

        .btn-div {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        
        .btndiv-inner button {
            border: 1px solid #000;
            background: transparent;
            border-radius: 50%;
            height: 23px;
            width: 23px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        #downloadBtn {
            border: 0;
            width: auto;
            height: 100%;
        }
        
        .btndiv-inner button i {
            font-size: 12px;
        }
        
        #fullscreenBtn {
            border: 0;
        }
        
        #fullscreenBtn i {
            font-size: 18px;
        }
		.catecss {
			text-align: center;
		}
    
</style>
    @section('content')
    <section class="transcript-main">
            <div class="transcript-1">
                <h3 class="transcript1-b">Transcripts</h3>
            </div>

            <div class="transcriptinner-1">
                <h3 class="transcriptinner1-a">Legal Education</h3>
                <h3 class="transcriptinner1-b">{{ $transcripts->title }}</h3>
                <h3 class="transcriptinner1-c">{{ $transcripts->description }}</h3>
            </div>
              
				@if(isset($FileCat))
					@foreach($FileCat as $pur)
							@php 
								$pdfFilePath = asset('storage/' . $pur->FileUploadCategory->file_path);
								$category = \App\Models\Category::find($pur->category_id); 	
							@endphp 
							<div class="transcript2-inner">
								<p class="transcriptinner2-p">
									<div class="iframe-container">
										<div class="transcriptinner-1">
											<h3 class="transcriptinner1-c">{{ $category->name }}</h3>
										</div>
										<iframe src="https://docs.google.com/viewerng/viewer?url={{ $pdfFilePath }}&embedded=true"
											frameborder="0" height="100%" width="100%"></iframe>
									</div>    
								</p>
							</div>
					@endforeach
				@endif
         
    </section>
    
    @endsection