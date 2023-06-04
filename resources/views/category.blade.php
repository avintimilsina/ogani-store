    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    @foreach ($sliderCategories as $sliderCategory)
                        <div class="col-lg-3">
                            <div class="categories__item set-bg" data-setbg={{ $sliderCategory->image_url }}>
                                <h5><a href="#">{{ $sliderCategory->name }}</a></h5>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </section>
