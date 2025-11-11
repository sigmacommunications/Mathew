 

@extends('layouts.app')
<style>
		#pdf-container1 {
            display: flex;
            flex-direction: column; /* Display pages vertically */
            align-items: center;
			width: 100%;
        }
        #pdf-render {
            border: 1px solid #ccc; /* Add border for better visibility */
        }
	
        .pdf-page {
            margin-bottom: 10px; /* Adjust spacing between pages */
			margin: 0 auto;
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
        
        .trans-summ {
                font-size: 16px;
                color: #000;
                font-weight: 400;
                line-height: 26px;
                text-align: center;
                width: 80%;
                margin: 30px auto;
        }
	
	@media only screen and (max-width: 767px) {
	.pdf-page {
			width: 90% !important;
        }
	}

    
</style>
    @section('content')
    <section class="transcript-main">
            <div class="transcript-1">
                <h3 class="transcript1-b">Transcript Summaries</h3>
            </div>

            <div>
                <p class="trans-summ">
                    Each Traverse Hearing transcript provides a rare first-hand view of multiple
					real-life scenarios giving rise to competing claims over personal jurisdiction
					and the validity of service of process. Read the presentation of conflicting
					evidence and legal arguments from counsel on both sides of the courtroom as
					they argue for – and against – dismissal for lack of personal jurisdiction. Learn
					from the valuable insights provided in colloquy among the court and
					counsel. An essential resource for the elite civil litigation lawyer!

                </p>
            </div>
            <div>
                <div class="transcript2-inner">
                    <p class="transcriptinner2-p">
					<div>
					 <!-- <iframe src="https://docs.google.com/viewerng/viewer?url=https://newyorkcasewinningstrategies.com/public/assets/Dev_PDF.pdf&embedded=true" frameborder="0" height="100%" width="100%">
					</iframe>-->
						<iframe id="pdfFrame" frameborder="0" src="" width="100%" height="100%"></iframe>
					</div>
                	</p>
                </div>
            </div>
            
    </section>

   <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pdfFrame = document.getElementById('pdfFrame');
            const pdfUrl = 'https://newyorkcasewinningstrategies.com/public/assets/Dev_PDF.pdf#toolbar=0';  // Replace with the actual PDF URL

            pdfFrame.src = pdfUrl;

            // Example code to reload the iframe (for testing)
        });
    </script>
		   
    @endsection