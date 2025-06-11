<style>
  #chat-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    font-family: sans-serif;
  }

  #chat-toggle {
    background-color: #007bff;
    color: white;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    font-size: 26px;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    cursor: pointer;
  }

  #chat-window {
    width: 340px;
    height: 450px;
    background: white;
    border-radius: 15px;
    border: 1px solid #ccc;
    display: none;
    flex-direction: column;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    overflow: hidden;
    margin-bottom: 10px;
  }

  #chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 12px;
    background: #f8f9fa;
  }

  .message {
    margin: 6px 0;
    max-width: 80%;
    padding: 10px 14px;
    border-radius: 18px;
    display: inline-block;
    line-height: 1.4;
  }

  .user {
    background-color: #007bff;
    color: white;
    align-self: flex-end;
    float: right;
    border-bottom-right-radius: 4px;
  }

  .bot {
    background-color: #e4e6eb;
    color: black;
    align-self: flex-start;
    float: left;
    border-bottom-left-radius: 4px;
  }

  #chat-input {
    display: flex;
    border-top: 1px solid #ddd;
    padding: 10px;
    background: white;
  }

  #chat-input input {
    flex: 1;
    border: none;
    padding: 10px;
    border-radius: 20px;
    background: #f1f1f1;
    outline: none;
    margin-right: 8px;
  }

  #chat-input button {
    background: #007bff;
    border: none;
    color: white;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    font-size: 18px;
    cursor: pointer;
  }
</style>

<div id="chat-widget">
  <div id="chat-window" class="d-flex flex-column">
    <div id="chat-messages"></div>
    <div id="chat-input">
      <input type="text" id="chat-text" placeholder="Nhập câu hỏi..." />
      <button id="send-btn">➤</button>
    </div>
  </div>
  <button id="chat-toggle">💬</button>
</div>

<script>
  const toggle = document.getElementById('chat-toggle');
  const windowBox = document.getElementById('chat-window');
  const input = document.getElementById('chat-text');
  const messages = document.getElementById('chat-messages');
  const sendBtn = document.getElementById('send-btn');

  toggle.onclick = () => {
    windowBox.style.display = windowBox.style.display === 'flex' ? 'none' : 'flex';
  };

  function appendMessage(text, sender = 'user') {
    const msg = document.createElement('div');
    msg.className = 'message ' + sender;
    msg.innerText = text;
    const wrapper = document.createElement('div');
    wrapper.appendChild(msg);
    messages.appendChild(wrapper);
    messages.scrollTop = messages.scrollHeight;
  }

  async function sendMessage() {
    const text = input.value.trim();
    if (!text) return;
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

  sendBtn.onclick = sendMessage;
  input.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') sendMessage();
  });
</script>
