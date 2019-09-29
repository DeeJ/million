# million
Generating a video counting to 1 million using PHP &amp; FFMPEG because of boredom &amp; beer. Comments &amp; common sense be damned.


Originally I wanted to make a video counting to 1 billion but ran into some issues... The insurmountable problem is YouTube's maximum video length (12 hours) & upload size (128GB). To a lesser a degree, cost (I did some rough calculations to generate everything on AWS but can't find them, they were... significant). Below are some rough metrics I worked out around file size & video length.

Tools:
My desktop PC
Image generation via PHP-GD (wrong tool for the job)
Video generation via ffmpeg (create video on the command line by adding 1 generated image per frame)
Boredom, beer & too much free time
Results from generating 1 million frames on my desktop:

Images: 
Average size 40kb
1 million images: 38gb (58.2gb on disk)
Time to generate images: 5hrs (roughly)
Video file size: 484mb
Video length: 4h 37m 46s
Time to generate video: 1.5hrs (roughly)
Rough calculations for 1 billion:

Images: 
38TB (FML)
Generate images: 208.33 days (Yeah...)
Video file size: 400GB (This I can actually deal with)
Video length: 192 days 21:26:40 (Have fun watching all of that)
Generate video: 100(ish) days (And a CPU pegged at 100% the entire time, R.I.P)
