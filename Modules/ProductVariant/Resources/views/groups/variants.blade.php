        <form action="#" method="post">
            @csrf
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="1%">#</th>
                        @foreach($variants_tree as $variant)
                        @php @endphp
                        <th>{{$variant['product_variant_name']}}</th>
                        @endforeach
                        <th>Product</th>
                    </tr>
                </thead>
                <tbody>
                    @php $idx=0 @endphp
                    @foreach($variants_tree[0]['childs']??[] as $variant)
                    @foreach($variants_tree[1]['childs']??[] as $child)
                    <tr id="variant{{$idx}}-container">
                        <td>
                            <div class="md-checkbox-inline">
                                <div class="md-checkbox">
                                    <input type="checkbox" class="row-disabler" data-id="{{$idx}}" id="variant{{$idx}}">
                                    <label for="variant{{$idx}}">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                    </label>
                                </div>
                            </div>
                        </td>
                        <td>{{$variant['product_variant_name']}}</td>
                        <td>{{$child['product_variant_name']}}</td>
                        <td><select class="select2b selector{{$variant['id_product_variant']}}{{$child['id_product_variant']}} selector{{$child['id_product_variant']}}{{$variant['id_product_variant']}}" name="products[{{$variant['id_product_variant']}}][{{$child['id_product_variant']}}]"></select></td>
                    </tr>
                    @php $idx++ @endphp
                    @endforeach
                    @endforeach
                </tbody>
            </table>
            <div class="text-center">
                <hr/>
                <button class="btn green"><i class="fa fa-check"></i> Save</button>
            </div>
        </form>
