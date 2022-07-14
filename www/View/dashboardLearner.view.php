
<h2 class="ml-2 mb-2">Reprendre les cours</h2>
<div class="row flex">
<?php foreach ($courses as $course): ?>
    <div class="course-thumbnail col-md-2">
                <img class="cover"  src="<?php echo $course->cover() ?>" alt="">
                <a  href="/show/course?id=<?php echo $course->getId() ?>"><?php echo $course->getName() ?></a>
                <p><?php echo $course->getDescription() ?></p>
                <a onclick="return confirm('are you sure to delete?');" href="/delete/course?id=<?php echo $course->getId() ?> "></i></a>
            </div>
<?php endforeach; ?>
</div>

<div onclick="location.href='/searchCourses';" class="col-md-5 bg-primary card mt-4" >
                    <h2>Search a course</h2>
                    <svg style="width: 70%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4816.41 4299.87"><defs><style>.cls-1{fill:#f0f0f0;}.cls-2,.cls-5,.cls-7,.cls-9{fill:none;stroke-linecap:round;stroke-linejoin:round;}.cls-2{stroke:#b7c7fb;}.cls-2,.cls-5,.cls-7{stroke-width:35.31px;}.cls-3{fill:#eaf0ff;}.cls-10,.cls-11,.cls-12,.cls-13,.cls-3,.cls-4,.cls-6,.cls-8{fill-rule:evenodd;}.cls-4{fill:#b2c3fb;}.cls-5{stroke:#b2c3fb;}.cls-6{fill:#f4f7ff;}.cls-7{stroke:#e9efff;}.cls-8{fill:#46dbc9;}.cls-9{stroke:#1b3c87;stroke-width:21.13px;}.cls-10{fill:#fff;}.cls-11{fill:#1b3c87;}.cls-12{fill:#edca55;}.cls-13{fill:#3c3744;}</style></defs><title>drawkit-grape-pack-illustration-8</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M3497.07,547.87c314.28,350.22,478.1,792.39,524.08,1228.7,45.13,436.31-27.59,867.61-204,1303.09-175.53,434.64-454.7,873.46-865.1,1079.92-411.24,206.45-954.54,179.7-1360.77-45.14C1186,3889.6,916.8,3465.82,640.14,3027S78.45,2134.31,175.41,1775.74s575.06-621,985.46-954.54C1571.27,488.53,1913.14,84.81,2316,12.09,2718.89-59.79,3182.79,197.65,3497.07,547.87Z"/><path class="cls-2" d="M563.37,3498.87,290.52,2744.49,17.66,1990.1,807.4,2131l789.75,140.88-516.89,613.5Z"/><path class="cls-3" d="M302.14,645.31H2856.55V3104.65H302.14Z"/><path class="cls-4" d="M1043,1049.38H2466.49v98.25H1043Z"/><path class="cls-4" d="M1043,1487.41H2466.49v98.24H1043Z"/><path class="cls-4" d="M1043,1925.43H2466.49v98.26H1043Z"/><path class="cls-5" d="M818.53,1004.33l-165.09,156-79-74.6"/><path class="cls-5" d="M818.53,1463.1l-165.09,156-79-74.6"/><path class="cls-5" d="M818.53,1921.87l-165.09,156-79-74.6"/><path class="cls-6" d="M1043,2363.47H2466.49v98.25H1043Z"/><path class="cls-6" d="M1043,2801.5H2466.49v98.26H1043Z"/><path class="cls-7" d="M3575.24,2624.93c0-337.86,273.89-611.75,611.76-611.75s611.75,273.89,611.75,611.75S4524.86,3236.69,4187,3236.69,3575.24,2962.8,3575.24,2624.93Z"/><path class="cls-8" d="M2672.68,1726.72c-157.16-31.37-352.48,163.83-338.82,451.92l189.6,39.37S2686.37,1729.45,2672.68,1726.72Z"/><path class="cls-9" d="M2312.75,2044.94a577.78,577.78,0,0,0-4.39,105"/><path class="cls-9" d="M2647.16,1698c-99.53-19.86-214.35,51.13-281.72,179"/><path class="cls-8" d="M3037.22,1608.88c593.32,0,708.1,686,629.28,1641.63-257.24,107.88-889.28,163.2-1168.65-6.91C2366.46,2875.71,2290.15,1608.88,3037.22,1608.88Z"/><path class="cls-10" d="M2609.69,993.35c0-251.74,152-455.82,339.51-455.82s339.5,204.08,339.5,455.82-152,455.83-339.5,455.83S2609.69,1245.1,2609.69,993.35Z"/><path class="cls-11" d="M2885.75,993.67c0-22,9.13-39.79,20.37-39.79s20.38,17.81,20.38,39.79-9.12,39.77-20.38,39.77S2885.75,1015.63,2885.75,993.67Z"/><path class="cls-9" d="M2792,1067.74c-.65,24.57-7.77,77.62-42,111.91"/><path class="cls-9" d="M2869.58,1278.62c28.46-3.87,64-14.87,86.68-48.51"/><path class="cls-9" d="M3507.73,2340.42c19.21,54.83,61.51,200.85,61.51,200.85s-299.58-153.77-440.4-224.84"/><path class="cls-9" d="M2778,2367.29l-35.76,117.91"/><path class="cls-9" d="M2891.44,1993.4l-47.59,156.88"/><path class="cls-9" d="M3130.73,3313.87c-250.47,16-518.54-8.42-675.4-103.93-98.11-274.7-165.51-1050.58,117.64-1426"/><path class="cls-9" d="M2742.92,1634.94c71.09-38.22,154.45-59.72,251.78-59.72,593.31,0,708.1,686,629.27,1641.63-39.14,16.41-86.95,31.61-140.88,45"/><path class="cls-9" d="M3611.76,3204.12c0,63.79-9.89,1018.51-9.89,1018.51"/><path class="cls-10" d="M2881.47,2194.31c-35.76,0-190.43,19.7-102.87,162.71,50.17,81.95,70.88,58.38,91.92,32.46,16.38,8.53,41.65,28.66,57.93,42.16-.12.27-.21.54-.33.81,44.24,34.5,628.07,544.2,748.14,574.76s255.1-88.19,307-177.51c57.3-98.5-51.34-498.12-70.52-542.19s-370.62,97.63-370.62,97.63,56.91,170.24,71.92,240.61c-33.11-18.63-555.26-273.84-623.27-352.3-.1.23-.24.63-.36.85C2965.52,2248.85,2909,2194.31,2881.47,2194.31Z"/><path class="cls-9" d="M2447.28,3194.82l-.72,923"/><path class="cls-9" d="M2889.55,3780.63c32.48,138.85,68.1,292.75,102.48,442"/><path class="cls-10" d="M3240.06,1182.1c-1.92,23.19-52.17,414.27-34.14,553.43-43.16,36.72-341.81,42.12-335.66-12.88,10.31-92.14,32.22-235.16,13.52-308"/><path class="cls-9" d="M2843.88,1682.07c10.31-92.13,25.57-191.78,15.38-273.86"/><path class="cls-9" d="M3209.65,1197.4c-1.94,23.19-48.14,358.39-30.11,497.55-17,14.49-73.8,24.1-135.93,27"/><path class="cls-9" d="M3071.62,1367.18c-44.95,29.5-95.46,46-148.86,46-118.27,0-222.41-81.18-283.2-204.32"/><path class="cls-9" d="M2593.41,1068.51a606.6,606.6,0,0,1-10.16-111.11c0-251.75,152-455.82,339.51-455.82s339.5,204.07,339.5,455.82c0,112.06-30.12,214.67-80.07,294.05"/><path class="cls-12" d="M3259.57,1244.41c38.08,6.9,102.43-198.83,115.57-322.92,23.38-221.06-208.46-502.31-381.66-519.7-34-3.41-72.4,31.58-51.55,90.13-42-44.06-152.11-102.33-247.21-114.56-144.48-18.56-214.29,77.45-214.29,120.22s25.94,176.64,77.79,218c-41.9-.52-79.18,3.33-83.84,37.26C2460,857.47,2519.31,952,2619.66,942.34c7-58.94,19.62-116,40.27-154.4C2676.7,939,3060.74,888.37,3060,913.59c-2.91,97.15,112.39,97.16,116.39,99.56C3265.43,1066.55,3198.85,1233.38,3259.57,1244.41Z"/><path class="cls-9" d="M2448.61,494.18c9,57.7,33.62,145.82,73.94,178-41.88-.52-79.18,3.33-83.84,37.26-12.37,90.12,29.89,172.69,105.93,187.77"/><path class="cls-9" d="M3233.74,557.15c-77.84-107.73-185-189.63-275.91-198.76-34-3.41-72.42,31.57-51.57,90.12-41.94-44.06-152.09-102.33-247.2-114.55-62.58-8-111.15,5.4-146.11,26.72"/><path class="cls-9" d="M3194.71,1142.22c2.11,31.22,7.61,54.85,29.2,58.77,38.07,6.91,102.44-198.82,115.56-322.91,3.85-36.32.8-74.25-7.74-112.36"/><path class="cls-9" d="M2607.15,785.6a253.88,253.88,0,0,1,17.13-41.07c16.77,151.06,400.8,100.43,400,125.65-.46,15.39,2,28.35,6.61,39.27"/><path class="cls-10" d="M3096.14,968a86,86,0,1,1,48.93,156.64,86.56,86.56,0,0,1-15.55-1.4"/><path class="cls-9" d="M3088.32,950.06a86,86,0,1,1,48.93,156.64,86.51,86.51,0,0,1-15.53-1.39"/><path class="cls-4" d="M2075.38,2167.68l624.22,99.68-150.94,945.12-624.21-99.68Z"/><path class="cls-9" d="M1895.46,3052.88l150.93-945.12,624.22,99.7L2622,2512.07"/><path class="cls-9" d="M2566.38,2860.15l-46.71,292.42-425.71-68"/><path class="cls-10" d="M1896.08,2932.79c-28.41-214.81-6.55-355.36,115.77-395.41,49.38-16.16.74,297.83-18.93,349.53S1919.37,2879.63,1896.08,2932.79Z"/><path class="cls-9" d="M1876.3,2701.57c-13.57-44.54-5.82-140.38,147.16-194.61"/><path class="cls-9" d="M1866.61,2833.25c-13.55-44.53-5.81-140.39,147.17-194.6"/><path class="cls-9" d="M1875.33,2946.54c-13.56-44.54-5.82-140.4,147.16-194.62"/><path class="cls-9" d="M3058,987.51a86.28,86.28,0,0,1,30.35-37.45"/><path class="cls-9" d="M3971.7,2726.08c-2.59,18.55-7,34.06-13.66,45.5-51.94,89.32-187,208.08-307,177.52s-696.76-552.28-748.14-574.77"/><path class="cls-9" d="M3887.51,2229.4c9.87,22.69,43.46,139.62,65.91,261.17"/><path class="cls-9" d="M2958.68,2234.14c-42.49-119.28-134.06-86.58-223.22-8.82"/><path class="cls-9" d="M2860.18,2249.51c-25-1.83-86.91,21.64-115.19,45.9"/><path class="cls-9" d="M2878.26,2323.9c-27-.59-71,21.12-104.8,37.68"/><path class="cls-8" d="M3450.44,1683.42c278.73-94.75,546.74,507.36,533.62,570.48s-451.86,190.42-502.43,150.56S3289,1738.3,3450.44,1683.42Z"/><path class="cls-9" d="M3556.51,2365.1c-54.35,9.08-96.41,10.54-110.09-.24-22.22-17.53-62.14-148.33-86.18-294.11"/><path class="cls-9" d="M3503.37,1635.73c244.36,35.17,457.21,522.16,445.48,578.56-7.16,34.43-141,88-269.34,123"/><polygon class="cls-13" points="3631.57 4222.63 3632.48 3258.83 2478.84 3251.49 2474.77 4222.63 3631.57 4222.63"/></g></g></svg> </div>