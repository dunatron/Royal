<picture>
    <%-- Simple image - depreciated by <picture> --%>
    <source srcset="$HeroImage.ScaleMaxWidth(320).URL" media="(max-width: 320px)">
    <source srcset="$HeroImage.ScaleMaxWidth(400).URL" media="(max-width: 400px)">
    <%-- Biggest size is actually a mobile size, breaks at 768 to a smaller desktop (690)--%>
    <source srcset="$HeroImage.ScaleMaxWidth(768).URL" media="(max-width: 768px)">
    <%-- Above 400px width --%>
    <source srcset="$HeroImage.ScaleMaxWidth(690).URL">
    <%-- Fallback needs to be large enough to fill slider at all screen sizes--%>
    <img src="$HeroImage.ScaleMaxWidth(690).URL" class="img-responsive">
</picture>