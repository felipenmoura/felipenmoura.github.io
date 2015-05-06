function makeRandom(max)
{
	if(!max)
		max= 600;
	rnd= Math.floor(Math.random()*max+1);
	return rnd;
}