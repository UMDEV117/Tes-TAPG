from confluent_kafka import Consumer, KafkaException

# Konfigurasi Kafka Consumer
conf = {
    'bootstrap.servers': 'pkc-lq8v7.eu-central-1.aws.confluent.cloud:9092',
    'group.id': 'web-b1835465-ee52-457b-a958-94e508710828',
    'auto.offset.reset': 'earliest',
    'security.protocol': 'SASL_SSL',
    'sasl.mechanism': 'PLAIN',
    'sasl.username': 'testuserkapg',
    'sasl.password': 'test123#'
}

consumer = Consumer(conf)
consumer.subscribe(["test_topic"])

try:
    while True:
        msg = consumer.poll(1.0)  # Tunggu pesan selama 1 detik
        if msg is None:
            continue
        if msg.error():
            raise KafkaException(msg.error())
        print(
            f"📥 Received message: {msg.key().decode('utf-8')} = {msg.value().decode('utf-8')}")
except KeyboardInterrupt:
    pass
finally:
    consumer.close()
