from confluent_kafka import Producer

# Konfigurasi Kafka Producer
conf = {
    'bootstrap.servers': 'pkc-lq8v7.eu-central-1.aws.confluent.cloud:9092',
    'security.protocol': 'SASL_SSL',
    'sasl.mechanism': 'PLAIN',
    'sasl.username': 'testuserkapg',
    'sasl.password': 'test123#'
}

producer = Producer(conf)

# Fungsi callback untuk memastikan pesan terkirim


def delivery_report(err, msg):
    if err is not None:
        print(f' Message delivery failed: {err}')
    else:
        print(f' Message delivered to {msg.topic()} [{msg.partition()}]')


# Kirim pesan
topic = "test_topic"

for i in range(5):
    message_key = str(i)
    message_value = f"value-{i}"
    producer.produce(topic, key=message_key,
                     value=message_value, callback=delivery_report)

producer.flush()
