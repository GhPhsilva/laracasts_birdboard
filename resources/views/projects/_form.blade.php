@csrf
<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="title">Title</label>
    <div class="control">
        <input type="text" name="title" class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
            placeholder="My next awesome project" value="{{ $project->title }}" required>
    </div>
</div>
<div class="field mb-6">
    <label for="">Description</label>
    <div class="control">
        <textarea name="description" rows="10"
            class="textarea bg-transparent border-grey-light rounded p-2 text-xs w-full"
            required>{{ $project->description }}</textarea>
    </div>
</div>
<div class="flex">
    <div class="control">
        <button type="submit" class="button is-link mr-2">{{ $buttonText }}</button>
    </div>
    <a href="{{ $project->path() }}" class="bg-black text-white no-underline rounded-lg text-sm py-2 px-5">Cancel</a>
</div>
@if ($errors->any())
    <div class="field mt-6">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-sm text-red">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
