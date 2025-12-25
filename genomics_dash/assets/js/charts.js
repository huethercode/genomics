// charts.js
const hg38_lengths = { "chr1": 248956422, "chr2": 242193529, "chr3": 
198295559 }; // etc.

function drawKaryoplot(data) {
    const width = 800, height = 400;
    d3.select("#karyoplot").selectAll("*").remove();
    
    const svg = d3.select("#karyoplot").append("svg")
        .attr("width", width).attr("height", height);

    // Map chromosomes to Y rows
    const yScale = d3.scaleBand()
        .domain(Object.keys(hg38_lengths))
        .range([0, height]).padding(0.4);

    // Draw Chromosome Bars
    svg.selectAll(".bg-bar")
        .data(Object.entries(hg38_lengths))
        .enter().append("rect")
        .attr("x", 50)
        .attr("y", d => yScale(d[0]))
        .attr("width", d => (d[1] / 250000000) * 700)
        .attr("height", 10)
        .attr("fill", "#eee");

    // Plot Variant Points
    svg.selectAll(".variant")
        .data(data)
        .enter().append("circle")
        .attr("cx", d => 50 + (d.pos / 250000000) * 700)
        .attr("cy", d => yScale(d.chr) + 5)
        .attr("r", 2)
        .attr("fill", "steelblue")
        .style("opacity", 0.6);
}
