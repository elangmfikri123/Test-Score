<p>{{ $question->pertanyaan }}</p>
<form>
    @foreach ($question->answers as $key => $answer)
        <div class="form-check d-flex align-items-center mb-2">
            <button type="button" class="btn btn-outline-primary me-2"
                style="width: 40px; height: 40px; font-size: 16px; padding: 0;">
                {{ chr(65 + $key) }}
            </button>
            <input class="form-check-input d-none" type="radio" name="answer"
                id="option{{ $key }}" value="{{ $answer->id }}">
            <label class="form-check-label" for="option{{ $key }}" style="cursor: pointer;">
                {{ $answer->jawaban }}
            </label>
        </div>
    @endforeach
</form>
