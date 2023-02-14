<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Document</title>
    <link rel="stylesheet" href="style.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chance/1.0.18/chance.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        svg {
            width: 400px;
            height: 400px;
        }

        img,
        .content,
        svg {
            max-width: 400px;
            max-height: 400px;
        }

        .dust {
            position: absolute;
        }

        .hide {
            display: none;
        }

        .glow-div {
            top: 0;
            left: 0;
            position: absolute;
            height: 80px;
            width: 80px;
            border-radius: 50%;
        }

        .time-div {
            top: 0;
            right: 0;
            position: absolute;
            height: 80px;
            width: 80px;
            border-radius: 50%;
        }

        .infinity,
        .gauntlet {
            cursor: pointer;
            position: absolute;
            left: -12px;
            height: 80px;
            width: 80px;
            user-select: none;
            -moz-user-select: none;
        }

        .gauntlet {
            cursor: pointer;
            position: absolute;
            left: -12px;
            height: 80px;
            width: 80px;
            user-select: none;
            -moz-user-select: none;
        }

        .snap {
            position: absolute;
            top: 0;
            left: -12px;
            height: 80px;
            width: 80px;
            background-image: url("https://www.google.com/logos/fnbx/thanos/thanos_snap.png");
            background-position: left;
            background-repeat: no-repeat;
            animation: snaps 2s steps(47);
        }

        @keyframes snaps {
            from {
                background-position: left;
            }
            to {
                background-position: right;
            }
        }

        .time {
            position: absolute;
            top: 0;
            left: -12px;
            height: 80px;
            width: 80px;
            background-image: url("https://www.google.com/logos/fnbx/thanos/thanos_time.png");
            background-position: left;
            background-repeat: no-repeat;
            animation: effect 2s steps(47);
        }

        @keyframes effect {
            from {
                background-position: left;
            }
            to {
                background-position: right;
            }
        }

        .para {
            position: absolute;
            top: 70px;
            left: 8px;
            font-family: "Roboto", san-seriff;
            color: red;
        }

        .paraTime {
            position: absolute;
            top: 70px;
            left: 8px;
            font-family: "Roboto", san-seriff;
            color: green;
        }
    </style>
</head>
<body>
<!-- Based on Red Stapler example at https://redstapler.co/thanos-snap-effect-javascript-tutorial/ -->
<div class="content">
    <!-- Change the Svg Here -->
    <svg
            version="1.1"
            id="Layer_1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            x="0px"
            y="0px"
            viewBox="0 0 1300.5 1666.6"
            xml:space="preserve"
    >
        <style type="text/css">
            .st0 {
                fill: #d81212;
                stroke: #020202;
                stroke-width: 1.075;
                stroke-miterlimit: 10;
            }

            .st1 {
                fill: #d81212;
            }

            .st2 {
                fill: #d81212;
                stroke: #020202;
                stroke-width: 1.2;
                stroke-miterlimit: 10;
            }
        </style>
        <g>
            <path
                    class="st0"
                    d="M1291.1,1068.9c-6-8.4-6-20.7-11-29.8c-8.6-15.7-15.4-35.3-29.1-44.8c-26.2-18.3-45.5-41.1-61.5-68.1
		c-13.1-21.7-26.7-42.9-40.8-63.9c-3.7-5.2-9.9-9.9-16.2-12.3c-27.2-9.4-41.9-30.9-54.2-54.7c-7.6-14.7-14.9-29.1-32.5-34.8
		c-2.9-0.8-5.2-6-5.8-9.4c-8.1-51-30.4-97.1-50.5-144c-9.2-21.5-18.8-43.2-28.5-65.4c30.6-15.2,46.1-34.3,38.5-67.8
		c-12.6-55.8-43.5-95.8-92.9-123c-3.7,5.2-6.5,9.4-9.9,14.4c-23-9.2-45.3-13.3-62.8,9.4c-12-9.7-22.5-18.3-33-27
		c-31.9-25.7-61.3-55.5-100.3-71.2c-4.7-1.8-12.3-2.6-13.6-6c-6.8-16.5-14.4-33.2-8.1-52.1c4.4-13.3,12.8-27,12.6-40.3
		c-1.3-48.9-13.3-96.3-30.4-142.4c-2.4-6-7.6-11.5-12.8-15.7C617.1-3.3,581.5-2.2,546.2,5.4c-24.9,5.2-47.6,17-63.3,38.5
		c-2.9,3.9-6.3,9.2-6.3,13.6c1,40.3,1,80.6,5.2,120.7c2.6,24.3,12.6,47.6,18.1,71.7c1.8,8.1,0.3,17.3,0.3,25.9
		c-1.6,1-2.9,1.8-4.4,2.9c-7.1-22-19.9-17.5-35.1-12.3c-27.2,9.4-53.9,18.3-72.2,42.7c-5.8,7.6-14.7,13.3-23,18.3
		c-4.7,2.6-12.6,4.2-17,2.1c-21.2-10.5-41.4-9.7-61.5,2.6c-7.9,5-16.2,9.2-24.3,14.1c-51.8,32.2-86.6,99.7-67,172.2
		c1,4.2,3.9,7.9,7.1,14.1c6.5-8.9,11.8-15.4,18.1-23.8c4.7,12.3,7.3,23,12.6,31.9c3.9,6.8,3.4,10.7-0.5,17.3
		c-16.2,26.2-32.2,51.8-39,83.2c-3.9,18.6-18.1,35.1-27.7,52.6c-1.3,2.1-3.9,3.7-6.3,5.2c-5.5,3.4-12.6,5-16.5,9.7
		c-10.5,12.6-19.6,26.2-29.1,39.5c-1.3,1.8-3.7,4.7-3.1,6c7.3,16-9.7,20.9-14.4,31.7c-2.9-12.3-5.8-24.6-8.9-37.2
		c-1.6-0.3-3.4-0.5-5-0.5c-11,19.9-22,39.8-33,59.4c-8.6,15.4-13.1,31.7-12.6,49.7c0.8,21.7,0.3,43.7,0.3,66.7
		c-15.4-5-16.8-4.7-20.2,7.1c-4.4,15.7-8.1,31.7-11.5,47.9c-8.6,38-5.8,75.4,4.2,112.6c3.1,11.3,6.8,23,13.3,32.2
		c4.4,6.5,12.6,10.5,10.7,19.9c-5.8,29.3,12,45,33.8,58.4c7.9,4.7,16,16,25.9,2.6c0.5-0.5,2.6,0,3.9,0.3c28,6.3,53.4,0,76.2-17
		c15.4-11.5,13.6-27.2-3.9-34c-6.5-2.6-14.4-2.1-21.5-3.9c-13.6-3.4-29.8,0.8-41.1-12.8c4.2-6.5,8.4-13.1,13.1-20.2
		c2.6,3.7,3.9,7.1,6.5,8.6c5.8,3.7,14.4,11,17.8,9.2c5.5-2.9,9.2-11.8,10.5-18.6c1.3-6.5-1.3-13.9-1.8-20.7c-0.5-6-3.1-13.1-1-17.8
		c6-13.3,1.6-24.9-3.9-36.4c-4.2-8.9-1.8-14.9,3.1-22.8c19.1-30.1,39-59.7,54.7-91.6c8.4-17,10.2-37.7,12.3-56.8
		c2.1-20.7,0.8-41.9,1.8-62.8c0.3-4.2,4.2-8.6,7.6-11.8c26.4-23.6,56.3-41.4,88-57.3c34.8-17.5,40.6-57.3,24.9-83.8
		c-3.1-5-10.7-7.6-13.3-12.6c-17.8-34.3-19.1-70.9-12-108.1c1-5-0.5-10.7,1-15.4c3.9-10.5,7.9-20.9,13.9-30.1
		c5-7.3,12.6-12.8,19.6-18.3s14.4-12,22.5-13.9c11-2.1,22.8,0.8,34.3,0c15.4-1,28.8,1,36.6,16.8c1.8,3.7,7.3,5.8,11.3,7.9
		c18.8,9.4,26.7,27,26.2,45.8c-0.5,30.4-2.1,61.3-8.1,90.8c-3.4,17.5,1,39.5-20.9,52.4c18.8,20.2,38.5,34.8,64.4,42.4
		c29.1,8.4,57.8,18.6,86.4,29.3c11,4.2,23,8.4,26.2,22.8c4.4,20.4,12.3,40.8,13.3,61.5c2.6,48.4,10.5,95.3,22.8,142.1
		c7.1,26.7,6.8,55.5,8.4,83.5c2.4,45.3,4.4,90.8,4.7,136.1c0.3,44.8-7.1,88.5-24.1,130.4c-1.8,4.4-4.7,9.7-8.6,12
		c-9.7,5.8-20.4,10.2-31.9,16c3.1,42.4,6.3,85.1,9.7,128c1.3,17.8,3.7,35.3,4.7,52.9c0.5,9.7,2.4,14.7,7.9,17
		c30.1,0.3,60.5,1,90.8,2.6h13.6c0,0.3,41.1,0,41.1-0.3h17.8c34.8-1.8,95.8-17.3,97.9-24.3c3.7-12.8,5.5-24.6-6.5-35.9
		c-9.2-8.4-5.5-16.8,4.7-23.8c5.2-3.7,10.2-10.7,11.3-17c15.4-89.5,13.3-179.3,2.9-268.8c-2.1-18.3-8.1-36.1-13.6-53.7
		c-5.5-18.3-12.8-36.4-18.8-54.4c-1-3.4-0.5-7.3-0.8-11.3c-0.3-5.2,1-10.7-0.3-15.4c-9.9-33-20.2-66-30.9-98.7
		c-4.7-14.4-5.5-30.9-21.5-39.5c-2.1-1.3-3.1-6.5-3.1-9.9c1.6-38.5,3.4-76.7,5.5-114.9c0.3-3.1,3.4-6.5,5.8-9.4
		c3.7-4.4,9.2-7.6,11.5-12.6c6-12.3,10.7-25.1,16.2-38.7c22.8,22.8,44.8,44.2,54.7,74.1c3.1,9.7,6.8,20.2,5.5,29.8
		c-2.9,25.4,6.8,44.8,23.6,61.8c19.6,19.9,39.8,39.3,59.7,58.9c2.4,2.4,5,5.2,5.2,8.1c1.8,16.5,13.1,26.4,24.9,36.1
		c27.2,22.5,55,44,81.7,66.7c11.5,9.9,21.7,22,30.4,34.6c9.2,13.6,15.7,29.1,22.5,41.4c-2.6,8.1-7.3,15.4-6,22
		c1.3,7.1,6.8,14.1,12,20.2c14.4,16.8,14.7,16.2,37.2,5.5c2.9-1.3,8.6,0.3,11.3,2.4c7.3,6.3,13.3,4.7,20.2-0.3
		c13.6-9.9,27.2-19.6,40.6-30.1c2.9-2.4,5-6.5,6.3-10.2c1.6-4.4,1.6-9.4,3.4-13.6C1300.3,1106.6,1305,1088.5,1291.1,1068.9
		L1291.1,1068.9z M486.5,122.4c-2.6-14.9,9.9-20.7,45.3-20.4C519.8,115.1,504.3,121.3,486.5,122.4z M579.7,91.8
		c17-2.1,33-4.4,49.2-5.5c3.9-0.3,8.1,3.9,13.6,7.1C624.5,104.6,588.3,103.3,579.7,91.8z M705.3,568.7c-28.5,0-56-23.6-56-48.4
		c0-24.9,17.8-43.7,41.6-44c26.7-0.3,49.5,23,49.5,50.8C740.4,549.6,724.7,568.4,705.3,568.7z M1205.3,1110
		c-12.3-0.5-24.3-14.1-24.6-28c-0.3-11.8,7.6-20.7,18.1-20.7c12.8,0,25.7,14.1,25.4,28.5C1223.9,1101.4,1215.5,1110.3,1205.3,1110z"
            />
            <path
                    class="st1"
                    d="M385.2,894.6c-9.4-24.3-22-47.9-27-73c-3.4-17,3.4-36.4,7.6-54.4c2.6-11.8,9.4-22.5,12.6-34
		c6.8-25.1,17.8-28.5,38-10.5c-0.3,0.8-0.3,1.8-0.8,2.4c-16.2,14.9-14.7,14.4-6.8,35.3c10.2,28.3,17.3,57.3,2.4,86.6
		c-7.9,15.7-14.9,31.7-22.2,47.6L385.2,894.6z M384.7,632h18.6c-6,14.4,6.5,20.7,12.8,29.3c0.5,0.8,9.7-3.4,13.9-6.8
		c2.1-1.6,1.3-6.5,2.1-11c6.5,15.7-2.9,29.1-23.6,33.2c-16,3.1-31.9,3.4-44.8-8.9c-4.4-4.2-6.8-10.2-8.1-16
		c5,4.2,9.7,10.5,15.4,11.8C375.8,664.5,386.3,640.7,384.7,632L384.7,632z M364,628.1c4.7-13.3,17.8-20.9,33.2-20.7
		c9.4,0.3,24.3,11,27.2,20.4C404.3,610.8,384.4,610.3,364,628.1z"
            />
            <g>
                <path
                        class="st0"
                        d="M363,1544.2l52.6-180.4l5.8-0.3l65.4,180.4L363,1544.2z"
                />
                <path
                        class="st2"
                        d="M132.6,1665.7h-20.2v-105.5h20.2V1665.7z M178.2,1601.3h47.4c4.2,0,7.3-1.3,9.7-4.2s3.7-6.8,4.4-12h-70.9
			v80.6h-20.2v-105.5h110.7v20.2c0,26.7-10.2,41.4-30.6,44l31.7,41.4h-24.6l-32.2-40.8h-25.4V1601.3z M378.9,1560.2v53.1
			c0,8.1-1,15.7-2.9,22c-1.8,6.5-4.4,12-8.1,16.5c-3.4,4.4-7.9,7.9-13.1,10.2c-5.2,2.4-11,3.7-17.5,3.7h-69.1v-52.9
			c0-8.1,1-15.2,2.9-21.7s4.7-12,8.1-16.5c3.7-4.4,7.9-8.1,13.1-10.5c5.2-2.4,11-3.7,17.5-3.7h69.1V1560.2z M358.5,1585.1h-48.4
			c-4.2,0-7.6,0.5-10.5,1.3c-2.9,0.8-5,2.4-6.5,4.7c-1.6,2.1-2.9,5-3.7,8.6c-0.8,3.7-1,8.1-1,13.6v27.5h48.4c3.9,0,7.3-0.5,10.2-1.3
			c2.9-0.8,5-2.4,6.8-4.4c1.8-2.1,2.9-5,3.7-8.6c0.8-3.7,1-8.1,1-13.6V1585.1z M506.9,1665.7h-21.5c-11.5-19.9-22.8-36.1-33.8-48.9
			c-11-12.6-22-21.7-32.7-27c-0.8-0.3-1.6-0.8-2.6-1c-0.8-0.5-1.8-1-2.9-1.3c0.3,3.9,0.3,6.3,0.3,7.3v70.9h-19.6v-105.5h17.5
			c6.5,2.6,13.1,6.3,19.6,10.5c6.3,4.4,12.6,9.2,18.6,14.7c6,5.5,12,11.5,17.5,18.1c5.8,6.5,11.3,13.3,16.5,20.4l3.7,5
			c-0.3-3.1-0.3-5.5-0.3-6.8v-62h19.6V1665.7z M522.6,1560.2h83.5c6.3,0,11.8,1.3,17,3.7s9.4,5.8,13.1,9.9c3.7,4.2,6.5,9.4,8.6,15.2
			c2.1,6,3.1,12.6,3.1,19.6v57.1h-20.2v-52.9c0-18.6-7.1-28-21.5-28h-63.6v80.6h-20.2L522.6,1560.2z M573.7,1598.2h20.4v67.8h-20.4
			V1598.2z M771,1665.7h-20.4v-40.8h-67.8v40.8h-20.2v-52.9c0-8.1,1-15.7,2.9-22.2s4.4-12,8.1-16.5c3.4-4.4,7.9-7.9,13.1-10.2
			c5.2-2.4,11-3.7,17.5-3.7h67v105.5L771,1665.7z M750.9,1585.1h-36.6c-6,0-11,0.5-14.7,1.3c-3.7,0.8-6.5,1.8-8.6,3.4
			c-2.1,1.6-3.7,3.1-4.4,5.2c-0.8,2.1-1.6,4.2-2.1,6.8h66.5V1585.1z M899.6,1665.7h-21.5c-11.5-19.9-22.8-36.1-33.8-48.9
			c-11-12.6-22-21.7-32.7-27c-0.8-0.3-1.6-0.8-2.6-1c-0.8-0.5-1.8-1-2.9-1.3c0.3,3.9,0.3,6.3,0.3,7.3v70.9h-19.6v-105.5h17.5
			c6.5,2.6,13.1,6.3,19.6,10.5c6.3,4.4,12.6,9.2,18.6,14.7c6,5.5,12,11.5,17.5,18.1c5.8,6.5,11.3,13.3,16.5,20.4l3.7,5
			c-0.3-3.1-0.3-5.5-0.3-6.8v-62h19.6V1665.7z"
                />
            </g>
        </g>
      </svg>
</div>

<div class="glow-div">
    <img
            class="infinity"
            src="https://www.google.com/logos/fnbx/thanos/thanos_idle.png"
    />
    <div class="snap hide"></div>
    <p class="para">Snap</p>
</div>


<div class="time-div">
    <img
            class="gauntlet"
            src="https://www.google.com/logos/fnbx/thanos/thanos_idle.png"
    />
    <div class="time hide"></div>
    <p class="paraTime">Reverse</p>
</div>

<script src="main.js"></script>
<script>
    const glove = document.querySelector(".infinity");
    const snap = document.querySelector(".snap");
    const content = document.querySelector(".content");
    const svg = document.querySelector("svg");

    var imageDataArray = [];
    var canvasCount = 40;

    $(".infinity").click(function() {
        // Hide default glove
        glove.style.display = "none";

        // Show Snap animation
        snap.className = "snap";

        setTimeout(() => {
            // Show the Glove Again
            glove.style.display = "block";

            // Hide the snap animation after 2500s
            snap.className = "hide";

            // get the svg data to make image data URL
            const svgData = new XMLSerializer().serializeToString(svg);

            // base 64 the svg data
            const svg64 = btoa(svgData);

            // base 64 svg data header
            const data64 = "data:image/svg+xml;base64,";

            // prepend the header to svg making image url
            const svgData64 = data64 + svg64;

            const image = document.createElement("img");

            // Add the image src
            image.src = svgData64;

            setTimeout(() => {
                // create a canvas and render the image there
                const canvas = document.createElement("canvas");

                // get the context and set 400px width and 400px height
                const ctx = canvas.getContext("2d");
                canvas.width = 400;
                canvas.height = 400;

                // draw the image on to the canvas
                ctx.drawImage(image, 44, 0, 312, 400);

                // Remove the svg from DOM
                content.removeChild(svg);

                let imageData = ctx.getImageData(44, 0, canvas.width, canvas.height);

                let rawPixelArr = imageData.data;

                // create more no. of empty imageData equal to this ImageData Length based on Canvas Count
                createBlankImageDatas(imageData);

                // put pixel info to imageDataArray (Weighted Distributed)
                for (let i = 0; i < rawPixelArr.length; i += 4) {
                    //find the highest probability canvas the pixel should be in
                    let p = Math.floor((i / rawPixelArr.length) * canvasCount);
                    let a = imageDataArray[weightedRandomDistrib(p)];
                    a[i] = rawPixelArr[i];
                    a[i + 1] = rawPixelArr[i + 1];
                    a[i + 2] = rawPixelArr[i + 2];
                    a[i + 3] = rawPixelArr[i + 3];
                }

                // Create a new canvas with the imageDataArray based on canvas count
                for (let i = 0; i < canvasCount; i++) {
                    let canvass = newCanvasFromImageData(
                        imageDataArray[i],
                        canvas.width,
                        canvas.height
                    );
                    canvass.classList.add("dust");
                    document.body.appendChild(canvass);
                }

                //apply animation
                $(".dust").each(function(index) {
                    setTimeout(() => {
                        animateTransform(
                            $(this),
                            100,
                            -100,
                            chance.integer({ min: -25, max: 25 }),
                            800 + 110 * index
                        );
                    }, 20 * index);

                    // remove the canvas from DOM tree when faded
                    $(this)
                        .delay(20 * index)
                        .fadeOut(110 * index + 800, "easeInQuint", () => {
                            $(this).remove();
                        });
                });
            }, 1);
        }, 2500);
    });

    // create empty imageData equal to original ImageData Length
    function createBlankImageDatas(imageData) {
        for (let i = 0; i < canvasCount; i++) {
            let arr = new Uint8ClampedArray(imageData.data);
            for (let j = 0; j < arr.length; j++) {
                arr[j] = 0;
            }
            imageDataArray.push(arr);
        }
    }

    function weightedRandomDistrib(peak) {
        var prob = [],
            seq = [];
        for (let i = 0; i < canvasCount; i++) {
            prob.push(Math.pow(canvasCount - Math.abs(peak - i), 3));
            seq.push(i);
        }
        return chance.weighted(seq, prob);
    }

    function animateTransform(elem, sx, sy, angle, duration) {
        var td = (tx = ty = 0);
        $({ x: 0, y: 0, deg: 0 }).animate(
            { x: sx, y: sy, deg: angle },
            {
                duration: duration,
                easing: "easeInQuad",
                step: function(now, fx) {
                    if (fx.prop == "x") tx = now;
                    else if (fx.prop == "y") ty = now;
                    else if (fx.prop == "deg") td = now;
                    elem.css({
                        transform:
                        "rotate(" + td + "deg)" + "translate(" + tx + "px," + ty + "px)"
                    });
                }
            }
        );
    }

    // Create a new canvas with the imageDataArray
    function newCanvasFromImageData(imageDataArray, w, h) {
        var canvas = document.createElement("canvas");
        canvas.width = w;
        canvas.height = h;
        tempCtx = canvas.getContext("2d");
        tempImageData = new ImageData(imageDataArray, w, h);
        tempCtx.putImageData(tempImageData, 44, 0);

        return canvas;
    }

    // Time Effect
    const gauntlet = document.querySelector(".gauntlet");
    const time = document.querySelector(".time");

    gauntlet.addEventListener("click", timeEffect);

    function timeEffect() {
        gauntlet.className = "hide";
        time.className = "time";
        setTimeout(() => {
            gauntlet.className = "gauntlet";
            time.className = "hide";
            content.appendChild(svg);
        }, 2500);
    }

</script>
</body>
</html>
