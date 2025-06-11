<style>
  #chat-bubble {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
  }

  #chat-icon {
    width: 60px;
    height: 60px;
    background-color: #007bff;
    border-radius: 50%;
    color: white;
    text-align: center;
    line-height: 60px;
    font-size: 30px;
    cursor: pointer;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
  }

  #chat-box {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 340px;
    height: 440px;
    background: white;
    border-radius: 12px;
    border: 1px solid #ccc;
    display: none;
    flex-direction: column;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    overflow: hidden;
    font-family: Arial, sans-serif;
  }

  #chat-content {
    flex: 1;
    padding: 12px;
    overflow-y: auto;
    background-color: #f1f2f6;
  }

  .message {
    max-width: 75%;
    padding: 10px 14px;
    margin: 8px;
    border-radius: 18px;
    line-height: 1.4;
    display: inline-block;
    clear: both;
  }

  .user-message {
    background-color: #007bff;
    color: white;
    float: right;
    border-bottom-right-radius: 4px;
  }

  .bot-message {
    background-color: #e5e5ea;
    color: black;
    float: left;
    border-bottom-left-radius: 4px;
  }

  #chat-input {
    display: flex;
    border-top: 1px solid #ddd;
    padding: 10px;
    background: white;
  }

  #chat-message {
    flex: 1;
    border: none;
    padding: 10px;
    border-radius: 20px;
    background: #f1f1f1;
    outline: none;
  }
</style>

<div id="chat-bubble">
  <div id="chat-icon">💬</div>
  <div id="chat-box">
    <div id="chat-content"></div>
    <div id="chat-input">
      <input type="text" id="chat-message" placeholder="Nhập câu hỏi..." />
    </div>
  </div>
</div>

<script>
  const icon = document.getElementById('chat-icon');
  const box = document.getElementById('chat-box');
  const content = document.getElementById('chat-content');
  const input = document.getElementById('chat-message');

  icon.onclick = () => {
    box.style.display = box.style.display === 'flex' ? 'none' : 'flex';
  };

  function appendMessage(text, sender) {
    const msg = document.createElement('div');
    msg.className = `message ${sender}-message`;
    msg.innerText = text;
    content.appendChild(msg);
    content.scrollTop = content.scrollHeight;
  }

  input.addEventListener('keypress', async (e) => {
    if (e.key === 'Enter' && input.value.trim()) {
      const text = input.value;
      appendMessage(text, 'user');
      input.value = '';

      const res = await fetch("{{ route('api.chatbot') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({ queryInput: { text: { text, languageCode: 'vi' } } })
      });

      const data = await res.json();
      const reply = data.fulfillmentText || '🤖 Mình chưa hiểu ý bạn.';
      appendMessage(reply, 'bot');
    }
  });
</script>
