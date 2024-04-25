@extends('frontlayout')
@section('title',$detail->title)
@section('content')
		<div class="row">
			<div class="col-md-8">
				@if(Session::has('success'))
					<p class="text-success">{{session('success')}}</p>
				@endif
				<div class="card">
					<h5 class="card-header">
						{{$detail->title}}
						<span class="float-right">Total Views <span class="badge barge-dark card text-white bg-dark" style="">{{$detail->views}}</span></span>
					</h5>
					<img src="{{asset('imgs/full/'.$detail->full_img)}}" class="card-img-top" alt="{{$detail->title}}">
					<div class="card-body">
						{{$detail->detail}}
					</div>
					<div class="card-footer">
						In <a href="{{url('category/'.Str::slug($detail->category->title).'/'.$detail->category->id)}}">{{$detail->category->title}}</a>
					</div>
				</div>
				@auth
				<!-- Add Comment -->
				<div class="card my-5">
					<h5 class="card-header">Add Comment</h5>
					<div class="card-body">
						<form method="post" action="{{url('save-comment/'.Str::slug($detail->title).'/'.$detail->id)}}">
						@csrf
						<textarea name="comment" class="form-control"></textarea>
						<input type="submit" class="btn btn-dark mt-2" />
					</div>
				</div>
				@endauth





				<!-- Fetch Comments -->
				<div class="card my-4">
					<h5 class="card-header">Comments
{{-- 						
						@if($comments)
							<h1>
								{{count($comments)}}
							</h1>
						@endif --}}

						@if($comments)
							<span class="badge badge-dark">{{ count($comments) }}</span>
						@else
							<span class="badge badge-dark">0</span>
						@endif
					</h5>


					
					<div class="card-body">
						@if($comments)
							@foreach($comments as $comment)
								<blockquote class="blockquote">
									@if($comment->user_id == $detail->id)
										<p class="mb-0">{{$comment->comment}}</p>

										@foreach($users as $user)
											@if($user->id == $comment->user_id)
												<p class="mb-0" style="font-size: 14px; font-weight: bold;">{{$user->email}}</p>
											@endif
											{{-- $ --}}

											{{-- {{$user->email}} --}}
										@endforeach
										


									@endif
								  
								  @if($comment->user_id==0)
								  <footer class="blockquote-footer">Admin</footer>
								  @else
								  {{-- <footer class="blockquote-footer">{{$comment->user->name}}</footer> --}}
								  @endif
								</blockquote>
								<hr/>
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<!-- Right SIdebar -->
			<div class="col-md-4">
				<!-- Search -->
				<div class="card mb-4">
					<h5 class="card-header">Search</h5>
					<div class="card-body">
						<form action="{{url('/')}}">
							<div class="input-group">
							  <input type="text" name="q" class="form-control" />
							  <div class="input-group-append">
							    <button class="btn btn-dark" type="button" id="button-addon2">Search</button>
							  </div>
							</div>
						</form>
					</div>
				</div>
				<!-- Recent Posts -->
				<div class="card mb-4">
					<h5 class="card-header">Recent Posts</h5>
					<div class="list-group list-group-flush">
						@if($recent_posts)
							@foreach($recent_posts as $post)
								<a href="../detail/{{$post->title}}/{{$post->id}}" class="list-group-item">{{$post->title}}</a>

								<h1>{{dd(dirname(3))}}</h1>
							@endforeach
						@endif
					</div>
				</div>
				<!-- Popular Posts -->
				<div class="card mb-4">
					<h5 class="card-header">Popular Posts</h5>
					<div class="list-group list-group-flush">
						@if($popular_posts)
							@foreach($popular_posts as $post)
								<a href="#" class="list-group-item">{{$post->title}} <span class="badge badge-info float-right">{{$post->views}}</span></a>
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
@endsection('content')